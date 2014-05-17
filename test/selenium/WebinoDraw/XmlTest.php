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
class XmlTest extends AbstractBase
{
    /**
     *
     */
    public function testXml()
    {
        $this->session->open($this->uri . 'xml');

        $loc = '/root/cdataExample';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('<![CDATA[ <p>CDATA EXAMPLE</p> ]]>', $elm->text());

        $loc = '/root/cdataOnEmptyExample';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('<![CDATA[ <p>CDATA ON EMPTY EXAMPLE</p> ]]>', $elm->text());
    }
}
