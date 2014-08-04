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
use WebinoDraw\Exception\InvalidInstructionException;

/**
 * Draw instructions utilities
 */
class Instructions extends ArrayObject implements
    InstructionsInterface
{
    /**
     * Stack space before instruction without index
     */
    const STACK_SPACER = 10;

    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        empty($array) or
            $this->merge($array);
    }

    /**
     * @param array $array
     */
    public function exchangeArray($array)
    {
        parent::exchangeArray([]);
        $this->merge($array);
        return $this;
    }

    /**
     * Sort by stackIndex
     *
     * @return array
     */
    public function getSortedArrayCopy()
    {
        $instructions = $this->getArrayCopy();
        ksort($instructions);
        return $instructions;
    }

    /**
     * Merge draw instructions
     *
     * If node with name exists merge else add,
     * or if same stackIndex throws exception.
     *
     * Instructions structure:
     * <pre>
     * [
     *   'node_name' => [
     *     'stackIndex' => '50',
     *     'customkey'  => 'customvalue',
     *     ....
     *   ],
     * ];
     * </pre>
     *
     * If no stackIndex is defined add as last with
     * space before.
     *
     * @param array $instructions Merge from
     * @return self
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
                $spec = array_replace_recursive($spec, [$iKey => $iSpec]);
            }
        }

        unset($spec);

        foreach ($mergeFrom as $index => $spec) {
            if (null === $spec) {
                continue;
            }

            if (!is_array($spec)) {
                throw new InvalidInstructionException('Instruction node spec expect array');
            }

            if (!isset($spec['stackIndex'])) {
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

            throw new InvalidInstructionException(sprintf('Stack index already exists `%s`', print_r($spec, true)));
        }

        parent::exchangeArray($mergeWith);
        return $this;
    }
}
