<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

/**
 *
 */
class HeavyTest extends AbstractTestCase
{
    /**
     *
     */
    public function testHeavy()
    {
        $this->openOk('heavy');
        $this->elementByXpath('//li[500]');
    }
}