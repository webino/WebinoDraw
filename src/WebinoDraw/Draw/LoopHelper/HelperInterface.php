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

/**
 *
 */
interface HelperInterface
{
    /**
     * @param ArrayObject $loopArgument
     * @param array $options
     */
    public function __invoke(ArrayObject $loopArgument, array $options);
}
