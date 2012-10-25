<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDrawTest\View\Helper;

use WebinoDraw\View\Helper\DrawElement;
use WebinoDrawTest\TestCase;

/**
 * Test class for WebinoDraw\View\Helper\DrawElement.
 *
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  UnitTests
 * @group       WebinoDraw_View
 */
class DrawElementTest extends TestCase
{
    protected $drawElement;
    protected $nodeListMock;

    protected function setUp()
    {
        $this->nodeListMock = $this->getMock('WebinoDraw\Dom\NodeList', array(), array(), '', null);
        $this->drawElement  = new DrawElement;
    }

    public function testDrawNodesValue()
    {
        $expected = 'customNodeValue';
        $options  = array(
            'value' => $expected,
        );

        $this->nodeListMock
            ->expects($this->exactly(1))
            ->method('setValue')
            ->with($expected);

        $this->drawElement->drawNodes($this->nodeListMock, $options);
    }

    public function testDrawNodesHtml()
    {
        $expected = '<testhtml/>';
        $options  = array(
            'html' => $expected,
        );

        $this->nodeListMock
            ->expects($this->exactly(1))
            ->method('setHtml')
            ->with($expected);

        $this->drawElement->drawNodes($this->nodeListMock, $options);
    }

    public function testDrawNodesReplace()
    {
        $expected = '<testhtml/>';
        $options  = array(
            'replace' => $expected,
        );

        $dom = new \DOMDocument;
        $dom->loadXML('<dummy><node/><node/></dummy>');

        $this->nodeListMock
            ->expects($this->once())
            ->method('getIterator')
            ->will(
                $this->returnValue(
                    new \IteratorIterator(
                        $dom->getElementsByTagName('node')
                    )
                )
            );

        $this->drawElement->drawNodes($this->nodeListMock, $options);
        $this->assertSame(1, $dom->getElementsByTagName('testhtml')->length);
    }
}
