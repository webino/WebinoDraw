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

use WebinoDraw\Dom\Draw;
use WebinoDrawTest\TestCase;

/**
 * Test class for WebinoDraw\Dom\Draw.
 *
 * @category    WebinoDraw
 * @package     WebinoDraw_Dom
 * @subpackage  UnitTests
 * @group       WebinoDraw_Dom
 */
class DrawTest extends TestCase
{
    protected $rendererMock;
    protected $draw;

    protected function setUp()
    {
        $this->rendererMock = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $this->draw         = new Draw($this->rendererMock);
    }

    public function testDrawEmptyThrowsException()
    {
        $this->setExpectedException('WebinoDraw\Exception\InvalidArgumentException');

        $xhtml = '';
        $spec  = array();
        $vars  = array();

        $this->draw->drawXhtml($xhtml, $spec, $vars);
    }

    public function testDrawXhtml()
    {
        $xhtml    = '<div/>';
        $spec     = array();
        $vars     = array();
        $expected = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"'
                    . ' "http://www.w3.org/TR/REC-html40/loose.dtd">'
                    . PHP_EOL . '<html><body><div></div></body></html>' . PHP_EOL;

        $this->assertEquals($expected, $this->draw->drawXhtml($xhtml, $spec, $vars));
    }

    public function testDrawHTML5()
    {
        $xhtml    = '<!DOCTYPE html><html><body><article/></body></html>';
        $spec     = array();
        $vars     = array();
        $expected = '<!DOCTYPE html>'
                    . PHP_EOL . '<html><body><article></article></body></html>' . PHP_EOL;

        $this->assertEquals($expected, $this->draw->drawXhtml($xhtml, $spec, $vars));
    }

    public function testDrawDomExpectsXpath()
    {
        $this->setExpectedException('WebinoDraw\Exception\InvalidArgumentException');
        $this->draw->drawDom(new \DOMDocument, array(), array());
    }

    public function testDrawDomSingleNode()
    {
        $xhtml      = '<test_node/>';
        $doc        = new \DOMDocument;
        $doc->loadXML($xhtml);
        $doc->xpath = new \DOMXPath($doc);

        $instructions = array(
            array(
                'test_node' => array(
                    'xpath'  => '.',
                    'helper' => 'drawElement'
                )
            ),
        );
        $vars = array();

        $drawHelperMock = $this->getMock('WebinoDraw\View\Helper\DrawElement', array(), array(), '', null);
        $drawHelperMock->expects($this->once())
            ->method('setVars')
            ->with($vars);
        $drawHelperMock->expects($this->once())
            ->method('drawNodes')
            ->with(
                $this->isInstanceOf('WebinoDraw\Dom\NodeList'),
                $instructions[0]['test_node']
            );

        $this->rendererMock->expects($this->once())
            ->method('plugin')
            ->with($instructions[0]['test_node']['helper'])
            ->will($this->returnValue($drawHelperMock));

        $this->draw->drawDom($doc, $instructions, $vars);
    }

    public function testDrawDom()
    {
        $xhtml      = '<test_node/>';
        $doc        = new \DOMDocument;
        $doc->loadXML($xhtml);
        $doc->xpath = new \DOMXPath($doc);

        $instructions = array(
            array(
                'test_node' => array(
                    'xpath'  => '.',
                    'helper' => 'drawElement'
                )
            ),
            array(
                'test_node2' => array(
                    'xpath'  => '.',
                    'helper' => 'drawElement'
                )
            )
        );
        $vars = array();

        $drawHelperMock = $this->getMock('WebinoDraw\View\Helper\DrawElement', array(), array(), '', null);
        $drawHelperMock->expects($this->exactly(2))
            ->method('setVars')
            ->with($vars);
        $drawHelperMock->expects($this->exactly(2))
            ->method('drawNodes')
            ->with(
                $this->isInstanceOf('WebinoDraw\Dom\NodeList'),
                $instructions[0]['test_node']
            );

        $this->rendererMock->expects($this->exactly(2))
            ->method('plugin')
            ->with($instructions[0]['test_node']['helper'])
            ->will($this->returnValue($drawHelperMock));

        $this->draw->drawDom($doc, $instructions, $vars);
    }
}
