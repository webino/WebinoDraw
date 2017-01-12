<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\LoopHelper;

use ArrayObject;
use WebinoDraw\Exception\InvalidLoopHelperOptionException;

/**
 *
 */
class ItemProperty implements HelperInterface
{
    /**
     * {@inheritDoc}
     * @throws InvalidLoopHelperOptionException
     */
    public function __invoke(ArrayObject $loopArgument, array $options)
    {
        if (empty($options['property'])) {
            throw new InvalidLoopHelperOptionException('property', $loopArgument['spec']);
        }
        if (empty($options['value'])) {
            throw new InvalidLoopHelperOptionException('value', $loopArgument['spec']);
        }
        if (empty($options['each'])) {
            throw new InvalidLoopHelperOptionException('each', $loopArgument['spec']);
        }

        $loopArgument['item'][$options['property']] = ($loopArgument['index'] % $options['each'] === 0)
                                                    ? $options['value']
                                                    : '';
    }
}
