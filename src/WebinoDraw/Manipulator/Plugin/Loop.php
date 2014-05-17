<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Exception;
use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Stdlib\VarTranslator;

class Loop extends AbstractPlugin implements PreLoopPluginInterface
{
    /**
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @var InstructionsRenderer
     */
    protected $instructionsRenderer;

    /**
     * @param VarTranslator $varTranslator
     * @param InstructionsRenderer $instructionsRenderer
     */
    public function __construct(VarTranslator $varTranslator,
                                InstructionsRenderer $instructionsRenderer)
    {
        $this->varTranslator        = $varTranslator;
        $this->instructionsRenderer = $instructionsRenderer;
    }

    /**
     * @param PluginArgument $arg
     * @return void
     * @throws Exception\MissingPropertyException
     */
    public function preLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['loop'])) {
            return;
        }

        if (empty($spec['loop']['base'])) {
            throw new Exception\MissingPropertyException(
                sprintf('Loop base expected in: %s', print_r($spec, 1))
            );
        }

        $arg->stopManipulation();

        $helper      = $arg->getHelper();
        $nodes       = $arg->getNodes();
        $translation = $arg->getTranslation();

        // TODO spec object default
        !empty($spec['loop']['offset']) or
            $spec['loop']['offset'] = 0;

        // TODO spec object default
        !empty($spec['loop']['length']) or
            $spec['loop']['length'] = null;

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

        empty($spec['loop']['shuffle']) or
            shuffle($items);

        $this->instructionsRenderer
            ->expandInstructions($spec)
            ->expandInstructions($spec['loop']);

        foreach ($nodes as $node) {

            $beforeNode = $node->nextSibling ? $node->nextSibling : null;
            $nodeClone  = clone $node;
            $parentNode = $node->parentNode;
            $node->parentNode->removeChild($node);

            // create loop argument for better callback support
            $loopArg = $this->varTranslator->subjectToArrayObject([
                'spec'       => $spec,
                'vars'       => $translation,
                'parentNode' => $parentNode,
                'beforeNode' => $beforeNode,
                'target'     => $this,
            ]);

            $loopArg['index'] = !empty($spec['loop']['index']) ? $spec['loop']['index'] : 0;
            foreach ($items as $key => $item) {
                $loopArg['index']++;

                $loopArg['key']  = $key;
                $loopArg['item'] = (array) $item;
                $loopArg['node'] = clone $nodeClone;

                // call loop item callback
                if (!empty($spec['loop']['callback'])) {
                    foreach ((array) $spec['loop']['callback'] as $callback) {
                        $callback = (array) $callback;
                        call_user_func(current($callback), $loopArg, (array) next($callback));

                        if (empty($loopArg['node'])) {
                            // allows to skip node by callback
                            continue 2;
                        }
                    }
                }

                $loopArg['item'][$translation->makeExtraVarKey('key')]   = (string) $loopArg['key'];
                $loopArg['item'][$translation->makeExtraVarKey('index')] = (string) $loopArg['index'];

                // create local translation
                $localTranslation = clone $translation;
                $this->varTranslator->translationMerge($localTranslation, $loopArg['item']);

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
                empty($spec['loop']['instructions']) or
                    $this->instructionsRenderer->subInstructions(
                        $nodes->create([$loopArg['node']]),
                        $spec['loop']['instructions'],
                        $localTranslation
                    );
            }

            empty($spec['instructions']) or
                $this->instructionsRenderer->subInstructions(
                    $nodes->create([$node]),
                    $spec['instructions'],
                    $translation
                );
        }
    }

    /**
     * @param PluginArgument $arg
     * @return void
     */
    protected function nothingToLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('onEmpty', $spec['loop'])) {
            return;
        }

        $helper      = $arg->getHelper();
        $nodes       = $arg->getNodes();
        $translation = $arg->getTranslation();
        $onEmptySpec = $spec['loop']['onEmpty'];

        if (!empty($onEmptySpec['locator'])) {
            $this->instructionsRenderer->subInstructions($nodes, [$onEmptySpec], $translation);
            return;
        }

        $helper->manipulateNodes($nodes, $onEmptySpec, $translation);

        $this->instructionsRenderer->expandInstructions($onEmptySpec);
        empty($onEmptySpec['instructions']) or
            $this->instructionsRenderer->subInstructions(
                $nodes,
                $onEmptySpec['instructions'],
                $translation
            );
    }
}
