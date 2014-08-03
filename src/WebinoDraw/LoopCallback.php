<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use ArrayObject;

/**
 *
 */
abstract class LoopCallback
{
    /**
     * Add custom item property
     *
     * Useful for e.g. even class for each 2.
     *
     * @param ArrayObject $loopArgument
     * @param array $options
     */
    public static function itemProperty(ArrayObject $loopArgument, array $options)
    {
        if (empty($options['property'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `property` option for spec '
                . print_r($loopArgument['spec'], true)
            );
        }

        if (empty($options['value'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `value` option for spec '
                . print_r($loopArgument['spec'], true)
            );
        }

        if (empty($options['each'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `each` option for spec '
                . print_r($loopArgument['spec'], true)
            );
        }

        $loopArgument['item'][$options['property']] = ($loopArgument['index'] % $options['each'] === 0)
                                                    ? $options['value']
                                                    : '';
    }

    /**
     * Add the element wrapper
     *
     * Useful for e.g. tables, loop the td and set the tr separator for each 3.
     *
     * @param ArrayObject $loopArgument
     * @param array $options
     */
    public static function elementWrapper(ArrayObject $loopArgument, array $options)
    {
        if (empty($options['elementName'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `elementName` option for  spec '
                . print_r($loopArgument['spec'], true)
            );
        }

        if (!empty($options['elementAttribs']) && !is_array($options['elementAttribs'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__
                . ' loop callback valid `elementAttribs` option for  spec '
                . print_r($loopArgument['spec'], true)
            );
        }

        if (empty($options['each'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `each` option for spec '
                . print_r($loopArgument['spec'], true)
            );
        }

        if (($loopArgument['index'] - 1) % $options['each']) {
            return;
        }

        // create wrapper
        $newParentNode = $loopArgument['parentNode']->ownerDocument
            ->createElement($options['elementName']);

        $parentNode = !empty($loopArgument['wrapperParentNode'])
                    ? $loopArgument['wrapperParentNode']
                    : $loopArgument['wrapperParentNode'] = $loopArgument['parentNode'];

        $beforeNode = !empty($loopArgument['wrapperBeforeNode'])
                    ? $loopArgument['wrapperBeforeNode']
                    : $loopArgument['wrapperBeforeNode'] = $loopArgument['beforeNode'];

        $loopArgument['beforeNode'] = null;
        $loopArgument['parentNode'] = $beforeNode
                                    ? $parentNode->insertBefore($newParentNode, $beforeNode)
                                    : $parentNode->appendChild($newParentNode);

        empty($options['elementAttribs']) or
            $newParentNode->setAttributes($options['elementAttribs']);
    }
}
