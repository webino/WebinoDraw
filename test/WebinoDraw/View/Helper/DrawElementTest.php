<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 * @package     WebinoDraw\View
 */

namespace WebinoDraw\View\Helper;

/**
 * Test class for WebinoDraw\View\Helper\DrawElement.
 *
 * @category    Webino
 * @package     WebinoDraw\View
 * @subpackage  UnitTests
 * @group       WebinoDraw\View
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class DrawElementTest
    extends \PHPUnit_Framework_TestCase
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

        $nodeTranslation = array('{$nodeValue}' => $node->nodeValue);

        $varTranslator->expects($this->exactly(2))
            ->method('array2translation')
            ->will($this->returnValue($nodeTranslation));

        $varTranslator->expects($this->once())
            ->method('translateString')
            ->with($options['value'], $nodeTranslation)
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
