<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Instructions;

use ArrayObject;
use DOMNodeList;
use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\Dom\Factory\NodeListFactory;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Draw\HelperPluginManager;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Factory\InstructionsFactory;
use WebinoDraw\Options\ModuleOptions;
use WebinoDraw\VarTranslator\Translation;
use Zend\Stdlib\ArrayUtils;

/**
 * Class InstructionsRenderer
 */
class InstructionsRenderer implements InstructionsRendererInterface
{
    /**
     * Makes the helper setting optional for common use cases
     */
    const DEFAULT_DRAW_HELPER = 'WebinoDrawElement';

    /**
     * @var HelperPluginManager
     */
    protected $drawHelpers;

    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @var NodeListFactory
     */
    protected $nodeListFactory;

    /**
     * @var InstructionsFactory
     */
    protected $instructionsFactory;

    /**
     * @var ModuleOptions
     */
    protected $drawOptions;

    /**
     * @param object|HelperPluginManager $drawHelpers
     * @param Locator $locator
     * @param NodeListFactory $nodeListFactory
     * @param InstructionsFactory $instructionsFactory
     * @param object|ModuleOptions $drawOptions
     */
    public function __construct(
        HelperPluginManager $drawHelpers,
        Locator $locator,
        NodeListFactory $nodeListFactory,
        InstructionsFactory $instructionsFactory,
        ModuleOptions $drawOptions
    ) {
        $this->drawHelpers         = $drawHelpers;
        $this->locator             = $locator;
        $this->nodeListFactory     = $nodeListFactory;
        $this->instructionsFactory = $instructionsFactory;
        $this->drawOptions         = $drawOptions;
    }

    /**
     * Render the DOMElement ownerDocument
     *
     * {@inheritDocs}
     * @throws InvalidArgumentException
     */
    public function render(NodeInterface $node, $instructions, array $vars)
    {
        $varTranslation = (new Translation($vars))->makeVarKeys();
        $drawInstructions = is_array($instructions)
                          ? $this->instructionsFactory->create($instructions)
                          : $instructions;

        if (!($drawInstructions instanceof Instructions)) {
            throw new InvalidArgumentException('Expected instructions as array|InstructionsInterface');
        }

        foreach ($drawInstructions->getSortedArrayCopy() as $specs) {
            $spec = (array) $this->createNodeSpec($specs);
            unset($specs);

            if ($this->resolveIsNodeDisabled($node, $spec)) {
                continue;
            }

            $varTranslation->translate($spec['locator']);
            $nodes = $this->locator->locate($node, $spec['locator']);
            if ($this->resolveIsEmptyNodes($nodes)) {
                continue;
            }

            $helper = !empty($spec['helper']) ? $spec['helper'] : self::DEFAULT_DRAW_HELPER;
            $this->drawNodes($nodes, $helper, $spec, $vars);
        }
    }

    /**
     * @param array $specs
     * @return array
     */
    protected function createNodeSpec(array $specs)
    {
        // one node per stackIndex
        $spec = current($specs);
        return $spec;
    }

    /**
     * @param DOMNodeList $nodes
     * @param string $helper
     * @param array $spec
     * @param array $vars
     */
    protected function drawNodes(DOMNodeList $nodes, $helper, array $spec, array $vars)
    {
        $this->drawHelpers->get((string) $helper)
            ->setVars($vars)
            ->__invoke($this->nodeListFactory->create($nodes), $spec);
    }

    /**
     * @param NodeInterface $node
     * @param array $spec
     * @return bool
     */
    protected function resolveIsNodeDisabled(NodeInterface $node, array $spec)
    {
        // locator not set or node already removed
        return empty($spec['locator']) || empty($node->ownerDocument);
    }

    /**
     * @param DOMNodeList|null $nodes
     * @return bool
     */
    protected function resolveIsEmptyNodes(DOMNodeList $nodes = null)
    {
        return empty($nodes->length);
    }

    /**
     * @param array|NodeList $nodes
     * @param array $instructions
     * @param ArrayObject $translation
     * @return self
     */
    public function subInstructions($nodes, array $instructions, ArrayObject $translation)
    {
        $nodeList = is_array($nodes) ? $this->nodeListFactory->create($nodes) : $nodes;
        if (!($nodeList instanceof NodeList)) {
            throw new InvalidArgumentException('Expected nodes as array|NodeList');
        }

        $drawInstructions = $this->instructionsFactory->create($instructions);
        $vars = $translation->getArrayCopy();

        foreach ($nodeList as $node) {
            $this->render($node, $drawInstructions, $vars);
        }

        return $this;
    }

    /**
     * @param array $spec
     * @param Translation
     * @return self
     */
    public function expandInstructions(array &$spec, Translation $translation = null)
    {
        if (empty($spec['instructionset'])) {
            return $this;
        }

        $translation and $translation->makeVarKeys(clone $translation)->translate($spec['instructionset']);

        $instructions = $this->instructionsFactory->create([]);
        foreach ($spec['instructionset'] as $instructionset) {
            $instructions->merge($this->drawOptions->instructionsFromSet($instructionset));
        }

        unset($spec['instructionset']);
        foreach ($instructions->getSortedArrayCopy() as $instruction) {
            $key = key($instruction);
            if (empty($spec['instructions'][$key])) {
                $spec['instructions'][$key] = current($instruction);
                continue;
            }
            $spec['instructions'][$key] = ArrayUtils::merge(current($instruction), $spec['instructions'][$key]);
        }

        return $this;
    }
}
