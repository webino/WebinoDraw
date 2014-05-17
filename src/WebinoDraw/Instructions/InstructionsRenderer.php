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

use ArrayAccess;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Exception\InvalidInstructionException;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Dom\NodeListFactory;
use WebinoDraw\HelperPluginManager as DrawHelperManager;
use WebinoDraw\Instructions\InstructionsFactory;
use WebinoDraw\WebinoDrawOptions as DrawOptions;

/**
 *
 */
class InstructionsRenderer implements InstructionsRendererInterface
{
    /**
     * Makes the helper setting optional for common use cases
     */
    const DEFAULT_DRAW_HELPER = 'WebinoDrawElement';

    protected $drawHelpers;
    protected $locator;
    protected $nodeListFactory;
    protected $instructionsFactory;
    protected $drawOptions;

    public function __construct(DrawHelperManager $drawHelpers, Locator $locator,
                                NodeListFactory $nodeListFactory,
                                InstructionsFactory $instructionsFactory, DrawOptions $drawOptions)
    {
        $this->drawHelpers         = $drawHelpers;
        $this->locator             = $locator;
        $this->nodeListFactory     = $nodeListFactory;
        $this->instructionsFactory = $instructionsFactory;
        $this->drawOptions         = $drawOptions;
    }

    /**
     * Render the DOMElement ownerDocument
     *
     * @param Instructions $instructions WebinoDraw instructions
     * @param Element $node DOMDocument element
     * @param array $vars Variables to render
     * @throws InvalidArgumentException
     * @throws InvalidInstructionException
     */
    public function render($instructions, Element $node, array $vars)
    {
        $drawInstructions  = is_array($instructions)
                           ? $this->instructionsFactory->create($instructions)
                           : $instructions;

        if (!($drawInstructions instanceof Instructions)) {
            throw new \InvalidArgumentException('Expected instructions as array|Instructions');
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
                ->setSpec($spec)
                ->setVars($vars)
                // todo deprecated spec argument
                ->__invoke($this->nodeListFactory->create($nodes), $spec);
        }
    }

    /**
     * @param array|NodeList $nodes
     * @param array $instructions
     * @param ArrayAccess $translation
     * @return self
     */
    public function subInstructions($nodes, array $instructions, ArrayAccess $translation)
    {
        $nodeList = is_array($nodes) ? $this->nodeListFactory->create($nodes) : $nodes;
        if (!($nodeList instanceof NodeList)) {
            throw new \InvalidArgumentException('Expected nodes as array|NodeList');
        }

        $drawInstructions = $this->instructionsFactory->create($instructions);
        $vars = $translation->getArrayCopy();

        foreach ($nodeList as $node) {
            $this->render($drawInstructions, $node, $vars);
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
