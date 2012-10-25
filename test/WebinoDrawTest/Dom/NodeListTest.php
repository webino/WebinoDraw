<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Dom
 */

namespace WebinoDrawTest\Dom;

use WebinoDraw\Dom\NodeList;
use WebinoDrawTest\TestCase;

/**
 * Test class for WebinoDraw\Dom\Draw.
 *
 * @category    Webino
 * @package     WebinoDraw_Dom
 * @subpackage  UnitTests
 * @group       WebinoDraw_Dom
 */
class NodeListTest extends TestCase
{
    public function testRemove()
    {
        $dom        = new \DOMDocument;
        $dom->loadXML('<box><dummyOne/><dummyTwo/></box>');
        $expected   = '<box/>';
        $dom->xpath = new \DOMXpath($dom);
        $nodeList   = new NodeList($dom->firstChild->childNodes);

        $nodeList->remove();

        $expected = '<?xml version="1.0"?>' . PHP_EOL . '<box/>' . PHP_EOL;
        $this->assertSame($expected, $dom->saveXML());
    }

    public function testRemoveByXpath()
    {
        $dom        = new \DOMDocument;
        $dom->loadXML('<box><dummyOne/><dummyTwo/></box>');
        $expected   = '<box><dummyOne/></box>';
        $dom->xpath = new \DOMXpath($dom);
        $nodeList   = new NodeList(array($dom->firstChild->firstChild));

        $nodeList->remove('//dummyTwo');

        $expected = '<?xml version="1.0"?>' . PHP_EOL . $expected . PHP_EOL;
        $this->assertSame($expected, $dom->saveXML());
    }

    public function testRemoveFromInvalidDocumentThrowsException()
    {
        $this->setExpectedException('WebinoDraw\Exception\RuntimeException');

        $dom        = new \DOMDocument;
        $dom->loadXML('<box><dummyOne/><dummyTwo/></box>');
        $nodeList   = new NodeList(array($dom->firstChild->firstChild));

        $nodeList->remove();
    }
}
