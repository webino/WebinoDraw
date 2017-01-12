<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

/**
 * Class HeavyTest
 */
class HeavyTest extends AbstractTestCase
{
    /**
     * Tests big data page
     */
    public function testHeavy()
    {
        $this->open('heavy');
        $this->elementByXpath('//li[500]');
    }
}
