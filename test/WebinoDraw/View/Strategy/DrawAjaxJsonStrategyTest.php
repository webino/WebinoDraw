<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Strategy;

use ArrayObject;
use DOMDocument;
use DOMNodeList;
use PHPUnit_Framework_Assert as PhpUnitAssert;
use ReflectionProperty;

/**
 * Test class for DrawAjaxJsonStrategy.
 * Generated by PHPUnit on 2013-03-18 at 21:40:26.
 */
class DrawAjaxJsonStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DrawAjaxJsonStrategy
     */
    protected $object;

    /**
     * @var \WebinoDraw\WebinoDraw
     */
    protected $service;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->service = $this->getMock('WebinoDraw\WebinoDraw', [], [], '', null);
        $this->object  = new DrawAjaxJsonStrategy($this->service);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawAjaxJsonStrategy::setEvent
     */
    public function testSetEvent()
    {
        $event = $this->getMock('WebinoDraw\AjaxEvent');

        // test fluent
        $this->assertSame($this->object, $this->object->setEvent($event));

        $this->assertSame($event, PhpUnitAssert::readAttribute($this->object, 'event'));
    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawAjaxJsonStrategy::getEvent
     */
    public function testGetEvent()
    {
        $this->assertThat(
            $this->object->getEvent(),
            $this->isInstanceOf('WebinoDraw\AjaxEvent')
        );

        $event = $this->getMock('WebinoDraw\AjaxEvent');

        $attribute = new ReflectionProperty($this->object, 'event');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $event);

        $this->assertSame($event, $this->object->getEvent());
    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawAjaxJsonStrategy::setEventManager
     */
    public function testSetEventManager()
    {
        $events = $this->getMock('Zend\EventManager\EventManager');

        $events->expects($this->once())
            ->method('setIdentifiers')
            ->with(
                $this->equalTo([
                    'WebinoDraw\View\Strategy\DrawAjaxJsonStrategy',
                    'WebinoDraw\View\Strategy\AbstractDrawAjaxStrategy',
                    'WebinoDraw',
                ])
            );

        // test fluent
        $this->assertSame($this->object, $this->object->setEventManager($events));

        $this->assertSame($events, PhpUnitAssert::readAttribute($this->object, 'eventManager'));
    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawAjaxJsonStrategy::getEventManager
     * @todo Implement testGetEventManager().
     */
    public function testGetEventManager()
    {
        $this->assertThat(
            $this->object->getEventManager(),
            $this->isInstanceOf('Zend\EventManager\EventManager')
        );

        $events = $this->getMock('Zend\EventManager\EventManager');

        $attribute = new ReflectionProperty($this->object, 'eventManager');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $events);

        $this->assertSame($events, $this->object->getEventManager());
    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawAjaxJsonStrategy::createContainer
     */
    public function testCreateContainer()
    {
        $dom        = new DOMDocument;
        $dom->loadXML('<xhtml/>');
        $xpath      = '//test';
        $xhtml      = '<xhtml></xhtml>';
        $domXpath   = $this->getMock('DOMXpath', [], [], '', false);
        $dom->xpath = $domXpath;

        $domXpath->expects($this->once())
            ->method('query')
            ->with($this->equalTo($xpath))
            ->will($this->returnValue($dom->childNodes));

        $this->assertEquals($xhtml, $this->object->createContainer($dom, $xpath));
    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawAjaxJsonStrategy::createFragments
     */
    public function testCreateFragments()
    {
        $dom        = new DOMDocument;
        $xhtml      = '<div id="testid"></div>';
        $dom->loadHTML($xhtml);
        $xpath      = '//test';
        $fragments  = ['fragment' => ['#testid' => $xhtml]];
        $domXpath   = $this->getMock('DOMXpath', [], [], '', false);
        $dom->xpath = $domXpath;

        $domXpath->expects($this->once())
            ->method('query')
            ->with($this->equalTo($xpath))
            ->will($this->returnValue($dom->getElementsByTagName('div')));

        $this->assertEquals($fragments, $this->object->createFragments($dom, $xpath));
    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawAjaxJsonStrategy::injectResponse
     */
    public function testInjectResponse()
    {
        $event          = $this->getMock('Zend\View\ViewEvent');
        $response       = $this->getMock('Zend\Http\PhpEnvironment\Response');
        $responseBody   = '<response_body/>';
        $options        = $this->getMock('WebinoDraw\WebinoDrawOptions');
        $instructions   = $this->getMock('WebinoDraw\Stdlib\DrawInstructions');
        $xhtml          = '<xhtml></xhtml>' . PHP_EOL;
        $dom            = new DOMDocument;
        $dom->loadXML($xhtml);
        $xpath          = $this->getMock('DOMXpath', [], [], '', false);
        $dom->documentElement->ownerDocument->xpath = $xpath;
        $containerXhtml = '<div></div>' . PHP_EOL;
        $containerDom   = new DOMDocument;
        $containerDom->loadHTML($containerXhtml);
        $containerDomXpath = $this->getMock('DOMXpath', [], [], '', false);
        $containerDom->documentElement->ownerDocument->xpath = $containerDomXpath;
        $containerXpath = '//container/xpath';
        $model          = $this->getMock('Zend\View\Model\ViewModel');

        $event->expects($this->once())
            ->method('getRenderer')
            ->will($this->returnValue($this->getMock('Zend\View\Renderer\PhpRenderer')));

        $event->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $response->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($responseBody));

        $this->service
            ->expects($this->once())
            ->method('getOptions')
            ->will($this->returnValue($options));

        $options->expects($this->once())
            ->method('getInstructions')
            ->will($this->returnValue($instructions));

        $options->expects($this->once())
            ->method('getAjaxContainerXpath')
            ->will($this->returnValue($containerXpath));

        $options->expects($this->once())
            ->method('getAjaxFragmentXpath')
            ->will($this->returnValue(''));

        $this->service
            ->expects($this->at(1))
            ->method('createDom')
            ->with($this->equalTo($responseBody))
            ->will($this->returnValue($containerDom));

        $this->service
            ->expects($this->at(2))
            ->method('createDom')
            ->will($this->returnValue($dom));

        $containerDomXpath
            ->expects($this->once())
            ->method('query')
            ->with($this->equalTo($containerXpath))
            ->will($this->returnValue($containerDom->getElementsByTagName('div')));

        $xpath->expects($this->once())
            ->method('query')
            ->will($this->returnValue(new DOMNodeList));

        $event->expects($this->any())
            ->method('getModel')
            ->will($this->returnValue($model));

        $model->expects($this->any())
            ->method('getVariables')
            ->will($this->returnValue(new ArrayObject));

        $model->expects($this->any())
            ->method('getChildren')
            ->will($this->returnValue([]));

        $this->service
            ->expects($this->once())
            ->method('drawDom');

        $response->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo('[]'));

        $this->object->injectResponse($event);
    }
}
