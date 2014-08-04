<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Instructions;

use ArrayObject;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\Factory\NodeListFactory;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Draw\HelperPluginManager;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Factory\InstructionsFactory;
use WebinoDraw\Options\ModuleOptions;

/**
 *
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
     * @param HelperPluginManager $drawHelpers
     * @param Locator $locator
     * @param NodeListFactory $nodeListFactory
     * @param InstructionsFactory $instructionsFactory
     * @param ModuleOptions $drawOptions
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
    public function render(Element $node, $instructions, array $vars)
    {
        $drawInstructions  = is_array($instructions)
                           ? $this->instructionsFactory->create($instructions)
                           : $instructions;

        if (!($drawInstructions instanceof Instructions)) {
            throw new InvalidArgumentException('Expected instructions as array|Instructions');
        }

        foreach ($drawInstructions->getSortedArrayCopy() as $specs) {
            // one node per stackIndex
            $spec = current($specs);
            unset($specs);

            if (empty($spec['locator']) || empty($node->ownerDocument)) {
                // locator not set or node already removed
                continue;
            }

            $nodes = $this->locator->locate($node, $spec['locator']);
            if (empty($nodes->length)) {
                continue;
            }

            $helper = !empty($spec['helper']) ? $spec['helper'] : self::DEFAULT_DRAW_HELPER;

            $this->drawHelpers->get($helper)
                ->setVars($vars)
                ->__invoke($this->nodeListFactory->create($nodes), $spec);
        }
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
     * @return self
     */
    public function expandInstructions(array &$spec)
    {
        if (empty($spec['instructionset'])) {
            return $this;
        }

        $instructions = $this->instructionsFactory->create([]);
        foreach ($spec['instructionset'] as $instructionset) {
            $instructions->merge($this->drawOptions->instructionsFromSet($instructionset));
        }

        unset($spec['instructionset']);
        foreach ($instructions->getSortedArrayCopy() as $instruction) {
            $spec['instructions'][key($instruction)] = current($instruction);
        }

        return $this;
    }
}
