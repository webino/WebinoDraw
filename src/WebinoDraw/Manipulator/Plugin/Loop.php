<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use ArrayObject;
use WebinoDraw\Cache\DrawCache;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Draw\Helper\AbstractHelper;
use WebinoDraw\Draw\LoopHelperPluginManager;
use WebinoDraw\Exception;
use WebinoDraw\Instructions\InstructionsRenderer;

/**
 * Class Loop
 */
class Loop extends AbstractPlugin implements PreLoopPluginInterface
{
    /**
     * @var InstructionsRenderer
     */
    protected $instructionsRenderer;

    /**
     * @var LoopHelperPluginManager
     */
    protected $loopHelpers;

    /**
     * @var DrawCache
     */
    protected $cache;

    /**
     * @param InstructionsRenderer $instructionsRenderer
     * @param LoopHelperPluginManager $loopHelpers
     * @param DrawCache $cache
     */
    public function __construct(
        InstructionsRenderer $instructionsRenderer,
        LoopHelperPluginManager $loopHelpers,
        DrawCache $cache
    ) {
        $this->instructionsRenderer = $instructionsRenderer;
        $this->loopHelpers = $loopHelpers;
        $this->cache = $cache;
    }

    /**
     * @param PluginArgument $arg
     */
    public function preLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['loop'])) {
            return;
        }

        if (empty($spec['cache'])) {
            $this->preLoopInternal($arg);
            return;
        }

        $event = $arg->getHelper()->getEvent();
        $nodes = $arg->getNodes();

        foreach ($nodes as $node) {

            $parentNodes = $nodes->create([$node->parentNode]);
            $loopEvent   = clone $event;
            $loopEvent->setNodes($parentNodes);

            if ($this->cache->load($loopEvent)) {
                continue;
            }

            $localArg = clone $arg;
            $localArg->setNodes($nodes->create([$node]));

            $this->preLoopInternal($localArg);
            $this->cache->save($loopEvent);
        }
    }

    /**
     * @param PluginArgument $arg
     * @throws Exception\MissingPropertyException
     */
    protected function preLoopInternal(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['loop']['base'])) {
            throw new Exception\MissingPropertyException(
                sprintf('Loop base expected in: %s', print_r($spec, true))
            );
        }

        $translation    = $arg->getTranslation();
        $varTranslation = $translation->makeVarKeys();

        $translation->containsVar($spec['loop']['base'])
            and $varTranslation->translate($spec['loop']['base']);

        if (empty($spec['loop']['base'])) {
            return;
        }

        $arg->stopManipulation();
        $nodes = $arg->getNodes();

        isset($spec['loop']['offset']) && $translation->containsVar($spec['loop']['offset'])
            and $varTranslation->translate($spec['loop']['offset']);

        // TODO spec object default
        empty($spec['loop']['offset'])
            and $spec['loop']['offset'] = 0;

        isset($spec['loop']['length']) && $translation->containsVar($spec['loop']['length'])
            and $varTranslation->translate($spec['loop']['length']);

        // TODO spec object default
        empty($spec['loop']['length'])
            and $spec['loop']['length'] = null;

        // TODO spec object
        $arg->setSpec($spec);

        $helper = $arg->getHelper();
        if (!$translation->offsetExists($spec['loop']['base'])
            && $helper instanceof AbstractHelper
        ) {
            $varTranslatorTranslation = $helper->getVarTranslator()->getTranslation();
            $varTranslatorTranslation->offsetExists($spec['loop']['base'])
                and $translation->offsetSet(
                    $spec['loop']['base'],
                    $varTranslatorTranslation->offsetGet($spec['loop']['base'])
                );
        }

        $items = array_slice(
            (array) $translation->fetch($spec['loop']['base']),
            $spec['loop']['offset'],
            $spec['loop']['length'],
            true
        );

        if (empty($items)) {
            $this->nothingToLoop($arg);
            return;
        }

        empty($spec['loop']['shuffle'])
            or shuffle($items);

        $this->instructionsRenderer
            ->expandInstructions($spec, $translation)
            ->expandInstructions($spec['loop'], $translation);

        // TODO spec object
        $arg->setSpec($spec);
        $this->nodesLoop($nodes, $items, $arg);
    }

    /**
     * @param PluginArgument $arg
     */
    protected function nothingToLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('onEmpty', $spec['loop'])) {
            return;
        }

        $helper = $arg->getHelper();
        $nodes  = $arg->getNodes();
        $translation = $arg->getTranslation();
        $onEmptySpec = $spec['loop']['onEmpty'];

        if (!empty($onEmptySpec['locator'])) {
            $this->instructionsRenderer->subInstructions($nodes, [$onEmptySpec], $translation);
            return;
        }

        $this->instructionsRenderer->expandInstructions($onEmptySpec, $translation);
        empty($onEmptySpec['instructions'])
            or $this->instructionsRenderer->subInstructions(
                $nodes,
                $onEmptySpec['instructions'],
                $translation
            );

        $helper->manipulateNodes($nodes, $onEmptySpec, $translation);
    }

    /**
     * @param NodeList $nodes
     * @param array $items
     * @param PluginArgument $arg
     * @return $this
     */
    protected function nodesLoop(NodeList $nodes, array $items, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        $translation = $arg->getTranslation();

        foreach ($nodes as $node) {

            $beforeNode = $node->nextSibling ? $node->nextSibling : null;
            $nodeClone  = clone $node;
            $parentNode = $node->parentNode;
            
            if (empty($node->parentNode)) {
                continue;
            }

            $node->parentNode->removeChild($node);

            $loopArg = new ArrayObject([
                'spec'   => $spec,
                'vars'   => $translation,
                'target' => $this,
                'parentNode' => $parentNode,
                'beforeNode' => $beforeNode,
            ]);

            $this->itemsLoop($items, $arg, $loopArg, $nodeClone);

            empty($spec['instructions'])
                or $this->instructionsRenderer->subInstructions(
                    $nodes->create([$node]),
                    $spec['instructions'],
                    $translation
                );
        }

        return $this;
    }

    /**
     * @param array $items
     * @param PluginArgument $arg
     * @param ArrayObject $loopArg
     * @param Element $nodeClone
     * @return $this
     */
    protected function itemsLoop(array $items, PluginArgument $arg, ArrayObject $loopArg, Element $nodeClone)
    {
        $spec   = $arg->getSpec();
        $helper = $arg->getHelper();
        $nodes  = $arg->getNodes();
        $translation = $arg->getTranslation();

        $loopArg['index'] = !empty($spec['loop']['index']) ? $spec['loop']['index'] : 0;
        foreach ($items as $key => $item) {
            $loopArg['index']++;

            $loopArg['key']  = $key;
            $loopArg['item'] = (array) $item;
            $loopArg['node'] = clone $nodeClone;

            if ($this->invokeLoopHelpers($spec['loop'], $loopArg)) {
                continue;
            }

            $loopArg['item'][$translation->makeExtraVarKey('key')]   = (string) $loopArg['key'];
            $loopArg['item'][$translation->makeExtraVarKey('index')] = (string) $loopArg['index'];

            // create local translation
            $localTranslation = clone $translation;
            $localTranslation->mergeValues($loopArg['item']);

            // add node
            if ($loopArg['beforeNode']) {
                $loopArg['parentNode']->insertBefore($loopArg['node'], $loopArg['beforeNode']);
            } else {
                $loopArg['parentNode']->appendChild($loopArg['node']);
            }

            // manipulate item nodes with local spec and translation
            $localSpec = $spec;
            unset($localSpec['loop']);
            $helper->manipulateNodes(
                $nodes->create([$loopArg['node']]),
                $localSpec,
                $localTranslation
            );

            // render sub-instructions
            empty($spec['loop']['instructions'])
                or $this->instructionsRenderer->subInstructions(
                    $nodes->create([$loopArg['node']]),
                    $spec['loop']['instructions'],
                    $localTranslation
                );
        }

        return $this;
    }

    /**
     * @param array $spec
     * @param ArrayObject $loopArg
     * @return bool
     */
    protected function invokeLoopHelpers(array $spec, ArrayObject $loopArg)
    {
        if (empty($spec['helper'])) {
            return false;
        }

        foreach ((array) $spec['helper'] as $helperOptions) {
            $this->invokeLoopHelper((array) $helperOptions, $loopArg);

            if (empty($loopArg['node'])) {
                // allows to skip node
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $helperOptions
     * @param ArrayObject $loopArg
     * @return $this
     * @throws Exception\InvalidLoopHelperException
     */
    protected function invokeLoopHelper(array $helperOptions, ArrayObject $loopArg)
    {
        $helper = current($helperOptions);
        if (is_string($helper)) {
            if (!$this->loopHelpers->has($helper)) {
                throw new Exception\InvalidLoopHelperException('Loop helper `' . $helper . '` not found');
            }

            $loopHelper = $this->loopHelpers->get($helper);
            $loopHelper($loopArg, (array) next($helperOptions));
            return $this;

        } elseif (is_callable($helper)) {
            call_user_func($helper, $loopArg, (array) next($helperOptions));
            return $this;
        }

        throw new Exception\InvalidLoopHelperException('Loop helper can\'t execute');
    }
}
