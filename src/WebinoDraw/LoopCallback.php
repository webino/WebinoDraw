<?php

namespace WebinoDraw;

use ArrayObject;

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
                'Expected the ' . __FUNCTION__ . ' loop callback `property` option for spec ' . print_r($loopArgument['spec'], true)
            );
        }

        if (empty($options['value'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `value` option for spec ' . print_r($loopArgument['spec'], true)
            );
        }

        if (empty($options['each'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `each` option for spec ' . print_r($loopArgument['spec'], true)
            );
        }

        $loopArgument['item'][$options['property']] = ($loopArgument['index'] % $options['each'] === 0) ? $options['value'] : '';
    }

    /**
     * Add the element separator
     *
     * Useful for e.g. tables, loop the td and set the tr separator for each 3.
     *
     * @param ArrayObject $loopArgument
     * @param array $options
     */
    public static function separator(ArrayObject $loopArgument, array $options)
    {
        if (empty($options['elementName'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `elementName` option for  spec ' . print_r($loopArgument['spec'], true)
            );
        }

        if (empty($options['each'])) {
            // todo InvalidLoopCallbackOptionException
            throw new \InvalidArgumentException(
                'Expected the ' . __FUNCTION__ . ' loop callback `each` option for spec ' . print_r($loopArgument['spec'], true)
            );
        }

        if (($loopArgument['index'] - 1) % $options['each']) {
            return;
        }

        $loopArgument['beforeNode'] = null;
        $newParentNode              = $loopArgument['parentNode']->ownerDocument->createElement($options['elementName']);
        $loopArgument['parentNode'] = $loopArgument['parentNode']->parentNode->appendChild($newParentNode);
    }
}
