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
class ElementWrapper implements HelperInterface
{
    /**
     * {@inheritDoc}
     * @throws InvalidLoopHelperOptionException
     */
    public function __invoke(ArrayObject $loopArgument, array $options)
    {
        if (empty($options['elementName'])) {
            throw new InvalidLoopHelperOptionException('elementName', $loopArgument['spec']);
        }
        if (!empty($options['elementAttribs']) && !is_array($options['elementAttribs'])) {
            throw new InvalidLoopHelperOptionException('elementAttribs', $loopArgument['spec']);
        }
        if (empty($options['each'])) {
            throw new InvalidLoopHelperOptionException('each', $loopArgument['spec']);
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
