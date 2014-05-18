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

use DOMDocument as DomDocument;
use DOMXPath as DomXpath;

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
        $dom = new DomDocument;
        $dom->load($this->uri . 'xml');
        $dom->xpath = new DomXpath($dom);

        $loc = '/root/cdataExample';
        $elm = $dom->xpath->query($loc)->item(0);
        $this->assertEquals('<p>CDATA EXAMPLE</p>', $elm->nodeValue);

        $loc = '/root/cdataOnEmptyExample';
        $elm = $dom->xpath->query($loc)->item(0);
        $this->assertEquals('<p>CDATA ON EMPTY EXAMPLE</p>', $elm->nodeValue);
    }
}
