<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Exception;

/**
 * Class ExceptionalDrawExceptionTrait
 */
trait ExceptionalDrawExceptionTrait
{
    /**
     * @var array
     */
    private $drawVariables = [];

    /**
     * @return array
     */
    public function getDrawVariables()
    {
        return $this->drawVariables;
    }

    /**
     * @param array $drawVariables
     * @return $this
     */
    public function setDrawVariables(array $drawVariables)
    {
        $this->drawVariables = $drawVariables;
        return $this;
    }
}
