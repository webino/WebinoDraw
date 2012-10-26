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

    public function testDrawNodesValueVar()
    {
        $var      = '{$nodeValue}';
        $options  = array(
            'value' => $var . 'customValue',
        );
        $node          = new \DOMElement('node0', 'value0');
        $varTranslator = $this->getMock('\WebinoDraw\Stdlib\VarTranslator');
        $testCase      = $this;

        $this->nodeListMock
            ->expects($this->once())
            ->method('setValue')
            ->will($this->returnCallback(
                function ($value, $preSet) use ($options, $node, $testCase) {
                    $result = $preSet($node, $options['value']);
                    $testCase->assertTrue($result);
                    return $value;
                }
            ));

        $varTranslator->expects($this->exactly(2))
            ->method('key2var')
            ->will($this->returnValue($var));

        $varTranslator->expects($this->once())  
            ->method('array2translation')
            ->will($this->returnValue(array()));

        $varTranslator->expects($this->once())
            ->method('translateString')
            ->with($options['value'], array('{$nodeValue}' => $node->nodeValue))
            ->will($this->returnValue(true));

        $this->drawElement->setVarTranslator($varTranslator);
        $this->drawElement->drawNodes($this->nodeListMock, $options);
    }

    public function testDrawNodesHtml()
    {
        $expected = '<testhtml/>';
        $options  = array(
            'html' => $expected,
        );

        $this->nodeListMock
            ->expects($this->once())
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

        $subnodeListMock = $this->getMock('WebinoDraw\Dom\NodeList', array(), array(), '', null);
        $subnodeListMock
            ->expects($this->exactly(2))
            ->method('replace')
            ->with($expected);

        $this->nodeListMock
            ->expects($this->once())
            ->method('getIterator')
            ->will(
                $this->returnValue(
                    new \ArrayIterator(array(null, null))
                )
            );

        $this->nodeListMock
            ->expects($this->exactly(2))
            ->method('createNodeList')
                 ->with(array(null))
            ->will($this->returnValue($subnodeListMock));

        $this->drawElement->drawNodes($this->nodeListMock, $options);
    }
}
