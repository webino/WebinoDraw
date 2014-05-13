<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Helper;

use DOMDocument;
use DOMXpath;

/**
 * Test class for DrawElement.
 * Generated by PHPUnit on 2013-03-18 at 20:28:40.
 */
class DrawElementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DrawElement
     */
    protected $object;

    /**
     * @var WebinoDraw\Dom\NodeList
     */
    protected $nodeList;

    /**
     *
     * @var Zend\View\Renderer\PhpRenderer
     */
    protected $view;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object   = new DrawElement;
        $this->nodeList = $this->getMock('WebinoDraw\Dom\NodeList', [], [], '', null);

        $this->view = $this->getMock('Zend\View\Renderer\PhpRenderer', ['escapeHtml']);
        $this->object->setView($this->view);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     *
     */
    public function testDrawNodesValue()
    {
        $dom        = new DOMDocument;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<box><dummyOne/><dummyTwo/></box>');
        $dom->xpath = new DOMXpath($dom);
        $nodeList   = $this->getMock('WebinoDraw\Dom\NodeList', [], [], '', null);
        $locator    = $this->getMock('WebinoDraw\Dom\Locator');
        $value      = 'testvalue';

        $spec = ['value' => $value];

        $this->view->expects($this->exactly(2))
            ->method('escapeHtml')
            ->with($value)
            ->will($this->returnValue($value));

        $nodeList
            ->expects($this->once())
            ->method('getLocator')
            ->will($this->returnValue($locator));

        $nodeList
            ->expects($this->once())
            ->method('getIterator')
            ->will($this->returnValue($dom->firstChild->childNodes));

        $this->object->drawNodes($nodeList, $spec);

        foreach ($dom->firstChild->childNodes as $childNode) {
            $this->assertEquals($value, $childNode->nodeValue);
        }
    }

    /**
     *
     */
    public function testDrawNodesHtml()
    {
        $dom        = new DOMDocument;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<box><dummyOne/><dummyTwo/></box>');
        $dom->xpath = new DOMXpath($dom);
        $nodeList   = $this->getMock('WebinoDraw\Dom\NodeList', [], [], '', null);
        $locator    = $this->getMock('WebinoDraw\Dom\Locator');
        $html       = '<testhtml/>';

        $spec = ['html' => $html];

        $nodeList
            ->expects($this->once())
            ->method('getLocator')
            ->will($this->returnValue($locator));

        $nodeList
            ->expects($this->once())
            ->method('getIterator')
            ->will($this->returnValue($dom->firstChild->childNodes));

        $this->object->drawNodes($nodeList, $spec);

        foreach ($dom->firstChild->childNodes as $childNode) {
            $this->assertEquals($html, $childNode->getInnerHtml());
        }
    }

    /**
     *
     */
    public function testDrawNodesReplace()
    {
        $dom        = new DOMDocument;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<box><dummyOne/><dummyTwo/></box>');
        $dom->xpath = new DOMXpath($dom);
        $nodeList   = $this->getMock('WebinoDraw\Dom\NodeList', [], [], '', null);
        $locator    = $this->getMock('WebinoDraw\Dom\Locator');
        $html       = '<testhtmlreplace/>';

        $spec = ['replace' => $html];

        $nodeList
            ->expects($this->once())
            ->method('getLocator')
            ->will($this->returnValue($locator));

        $nodeList
            ->expects($this->once())
            ->method('getIterator')
            ->will($this->returnValue($dom->firstChild->childNodes));

        $this->object->drawNodes($nodeList, $spec);

        foreach ($dom->firstChild->childNodes as $childNode) {
            $this->assertEquals($html, $childNode->getOuterHtml());
        }
    }
}
