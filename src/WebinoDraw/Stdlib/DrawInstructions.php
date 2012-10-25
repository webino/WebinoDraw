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
}
