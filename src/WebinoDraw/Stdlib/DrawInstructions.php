<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Stdlib;

use ArrayObject;
use DOMElement;
use DOMNodeList;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Exception\InvalidInstructionException;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\NodeList;
use Zend\View\Renderer\PhpRenderer;

/**
 * Draw instructions utilities
 */
class DrawInstructions extends ArrayObject implements
    DrawInstructionsInterface
{
    /**
     * Makes the helper setting optional for common use cases
     */
    const DEFAULT_DRAW_HELPER = 'WebinoDrawElement';

    /**
     * Stack space before instruction without index
     */
    const STACK_SPACER = 10;

    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @var NodeList
     */
    protected $nodeListPrototype;

    /**
     * @param array $array
     */
    public function __construct(array $array = null)
    {
        if (null !== $array) {
            $this->merge($array);
        }
    }

    /**
     * @param array $array
     */
    public function exchangeArray($array)
    {
        parent::exchangeArray(array());
        $this->merge($array);

        return $this;
    }

    /**
     * @return Locator
     */
    public function getLocator()
    {
        if (null === $this->locator) {
            $this->setLocator(new Locator);
        }
        return $this->locator;
    }

    /**
     * @param Locator $locator
     * @return DrawInstructions
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
        return $this;
    }

    /**
     * @return NodeList
     */
    public function getNodeListPrototype()
    {
        if (null === $this->nodeListPrototype) {
            $this->setNodeListPrototype(new NodeList);
        }
        return $this->nodeListPrototype;
    }

    /**
     * @param NodeList $nodeListPrototype
     * @return DrawInstructions
     */
    public function setNodeListPrototype(NodeList $nodeListPrototype)
    {
        $this->nodeListPrototype = $nodeListPrototype;
        return $this;
    }

    /**
     * @param DOMNodeList $nodes
     * @return NodeList
     */
    public function cloneNodeListPrototype(DOMNodeList $nodes)
    {
        $nodeList = clone $this->getNodeListPrototype();
        $nodeList->setNodes($nodes);
        return $nodeList;
    }

    /**
     * Merge draw instructions
     *
     * If node with name exists merge else add,
     * or if same stackIndex throws exception.
     *
     * Instructions structure:
     * <pre>
     * array(
     *   'node_name' => array(
     *     'stackIndex' => '50',
     *     'customkey'  => 'customvalue',
     *     ....
     *   ),
     * );
     * </pre>
     *
     * If no stackIndex is defined add as last with
     * space before.
     *
     * @param array $instructions Merge from
     * @return DrawInstructions
     * @throws InvalidInstructionException
     */
    public function merge(array $instructions)
    {
        $mergeWith     = $this->getArrayCopy();
        $mergeFrom     = $instructions;
        $instructionsN = count($mergeWith) * self::STACK_SPACER;

        foreach ($mergeWith as &$spec) {

            foreach ($mergeFrom as $iKey => $iSpec) {

                if (key($spec) != $iKey) {
                    continue;
                }

                // merge existing spec
                unset($mergeFrom[$iKey]);
                $spec = array_replace_recursive($spec, array($iKey => $iSpec));
            }
        }

        unset($spec);

        foreach ($mergeFrom as $index => $spec) {
            if (null === $spec) {
                continue;
            }

            if (!is_array($spec)) {
                throw new InvalidInstructionException(
                    sprintf('Instruction node spec expect array', print_r($spec, 1))
                );
            }

            if (!isset($spec['stackIndex']) ) {

                // add without stack index
                $stackIndex = $instructionsN + self::STACK_SPACER;

                if (!isset($mergeWith[$stackIndex])) {

                    $instructionsN = $stackIndex;
                    $mergeWith[$stackIndex][$index] = $spec;
                    continue;
                }

                unset($stackIndex);

            } elseif (!isset($mergeWith[$spec['stackIndex']])) {

                // add with stackindex
                $mergeWith[$spec['stackIndex']][$index] = $spec;
                continue;
            }

            throw new InvalidInstructionException(
                sprintf('Stack index already exists `%s`', print_r($spec, 1))
            );
        }

        parent::exchangeArray($mergeWith);

        return $this;
    }

    /**
     * Render the DOMElement ownerDocument
     *
     * @param DOMElement $node DOMDocument element.
     * @param PhpRenderer $renderer Provider of view helpers.
     * @param array $vars Variables to render.
     * @throws InvalidArgumentException
     * @throws InvalidInstructionException
     */
    public function render(DOMElement $node, PhpRenderer $renderer, array $vars)
    {
        if (empty($node->ownerDocument->xpath)) {
            throw new InvalidArgumentException(
                'Expects document with XPATH'
            );
        }

        $instructions = $this->getArrayCopy();

        // sort by stackIndex
        ksort($instructions);

        foreach ($instructions as $specNode) {

            // one node per stackIndex
            $spec = current($specNode);

            if (empty($spec['locator'])) {
                continue;
            }

            $nodes = $node->ownerDocument->xpath->query(
                $this->getLocator()->set($spec['locator'])->xpathMatchAny(),
                $node
            );

            // skip missing node
            if (empty($nodes->length)) {
                continue;
            }

            !empty($spec['helper']) or
                $spec['helper'] = self::DEFAULT_DRAW_HELPER;

            $plugin = $renderer->plugin($spec['helper']);
            $plugin->setVars($vars);
            $plugin(
                $this->cloneNodeListPrototype($nodes),
                $spec
            );
        }
    }
}
