<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Stdlib
 */

namespace WebinoDraw\Stdlib;

use WebinoDraw\Exception;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Dom\XpathUtils;
use Zend\View\Renderer\PhpRenderer;

/**
 * Draw instructions utilities.
 *
 * @category    Webino
 * @package     WebinoDraw_Stdlib
 */
abstract class DrawInstructions
{
    /**
     * Stack space before instruction without index.
     */
    const STACK_SPACER = 10;

    /**
     * Merge draw instructions.
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
     * @param  array $_instructions Merge with.
     * @param  array $instructions Merge from.
     * @return array Merged instructions.
     * @throws WebinoDraw\Exception\InvalidInstructionException
     */
    public static function merge(array $_instructions, array $instructions)
    {
        $instructionsN = count($_instructions) * self::STACK_SPACER;

        foreach ($_instructions as &$spec) {
            foreach ($instructions as $iKey => $iSpec) {
                if (key($spec) != $iKey) {
                    continue;
                }
                // merge existing spec
                unset($instructions[$iKey]);
                $spec = array_replace_recursive($spec, array($iKey => $iSpec));
            }
        }
        unset($spec);
        foreach ($instructions as $index => $spec) {

            if (!is_array($spec)) {
                throw new Exception\InvalidInstructionException(
                    sprintf('Instruction node spec expect array', print_r($spec, 1))
                );
            }

            if (!isset($spec['stackIndex']) ) {
                // add without stack index
                $stackIndex = $instructionsN + self::STACK_SPACER;
                if (!isset($_instructions[$stackIndex])) {
                    $instructionsN = $stackIndex;
                    $_instructions[$stackIndex][$index] = $spec;
                    continue;
                }
                unset($stackIndex);

            } elseif (!isset($_instructions[$spec['stackIndex']])) {
                // add with stackindex
                $_instructions[$spec['stackIndex']][$index] = $spec;
                continue;
            }
            throw new Exception\InvalidInstructionException(
                sprintf('Stack index already exists `%s`', print_r($spec, 1))
            );
        }
        return $_instructions;
    }

    /**
     * Return value in depth from multidimensional array.
     *
     * @param  array $subject Multidimensional array.
     * @param  string $base Something like: value.in.the.depth
     * @return array Result value.
     */
    public static function &toBase(array $subject, $base)
    {
        $value = $subject;
        $frags = explode('.', $base);

        foreach ($frags as $key) {
            // undefined
            if (empty($value[$key])) {
                $value = null;
                break;
            }
            $value = &$value[$key];
        }
        return $value;
    }

    /**
     * Render DOMElement ownerDocument.
     *
     * @param  \DOMElement $node DOMDocument element.
     * @param  \Zend\View\Renderer\PhpRenderer $renderer Provider of view helpers.
     * @param  array $instructions Draw instructions array.
     * @param  array $vars Variables to render.
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidInstructionException
     */
    public static function render(\DOMElement $node, PhpRenderer $renderer, array $instructions, array $vars)
    {
        if (empty($node->ownerDocument->xpath)) {
            throw new Exception\InvalidArgumentException(
                'Expects document with XPATH'
            );
        }

        foreach ($instructions as $key => $spec) {
            $xpath = array();

            is_string($key) or $spec = current($spec);

            // skip unmapped instructions
            if (empty($spec['xpath']) && empty($spec['query'])) {
                continue;
            }

            empty($spec['xpath']) or
                $xpath = array_merge(
                    $xpath,
                    XpathUtils::arrayXpath($spec['xpath'])
                );

            // transform css query to xpath
            empty($spec['query']) or
                $xpath = array_merge(
                    $xpath,
                    XpathUtils::arrayCss2Xpath($spec['query'])
                );

            if (empty($xpath)) {
                throw new Exception\InvalidInstructionException(
                    sprintf("Option `xpath` expected '%s'", print_r($spec, 1))
                );
            }

            $nodes = $node->ownerDocument->xpath->query(
                join('|', $xpath),
                $node
            );

            // skip missing node
            if (empty($nodes->length)) {
                continue;
            }

            if (empty($spec['helper'])) {
                throw new Exception\InvalidInstructionException(
                    sprintf("Option `helper` expected in '%s'", print_r($spec, 1))
                );
            }

            $renderer->plugin($spec['helper'])
                     ->setVars($vars)
                     ->drawNodes(new NodeList($nodes), $spec);
        }
    }
}
