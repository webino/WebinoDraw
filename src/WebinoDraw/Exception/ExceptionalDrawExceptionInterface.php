<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2016-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Exception;

/**
 * Interface ExceptionalDrawExceptionInterface
 */
interface ExceptionalDrawExceptionInterface
{
    /**
     * @return array
     */
    public function getDrawVariables();
}
