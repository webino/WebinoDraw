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

use PHPWebDriver_WebDriverBy as By;

/**
 *
 */
class HeavyTest extends AbstractBase
{
    /**
     *
     */
    public function testHeavy()
    {
        $this->session->open($this->uri . 'heavy');
        $this->assertNotContains('Server Error', $this->session->title());

        $this->session->element(By::XPATH, '//li[500]');
    }
}
