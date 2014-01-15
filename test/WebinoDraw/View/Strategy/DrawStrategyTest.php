<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Strategy;

use ArrayObject;
use DOMDocument;

/**
 * Test class for DrawStrategy.
 * Generated by PHPUnit on 2013-03-18 at 20:29:08.
 */
class DrawStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DrawStrategy
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
        $this->service = $this->getMock('WebinoDraw\WebinoDraw', array(), array(), '', null);
        $this->object  = new DrawStrategy($this->service);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawStrategy::injectResponse
     */
    public function testInjectResponse()
    {
        $event        = $this->getMock('Zend\View\ViewEvent');
        $response     = $this->getMock('Zend\Http\PhpEnvironment\Response');
        $responseBody = '<response_body/>';
        $options      = $this->getMock('WebinoDraw\WebinoDrawOptions');
        $instructions = $this->getMock('WebinoDraw\Stdlib\DrawInstructions');
        $xhtml        = '<xhtml></xhtml>' . PHP_EOL;
        $dom          = new DOMDocument;
        $dom->loadXML($xhtml);
        $model        = $this->getMock('Zend\View\Model\ViewModel');

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

        $this->service
            ->expects($this->once())
            ->method('createDom')
            ->with($this->equalTo($responseBody))
            ->will($this->returnValue($dom));

        $event->expects($this->any())
            ->method('getModel')
            ->will($this->returnValue($model));

        $model->expects($this->any())
            ->method('getVariables')
            ->will($this->returnValue(new ArrayObject));

        $model->expects($this->any())
            ->method('getChildren')
            ->will($this->returnValue(array()));

        $this->service
            ->expects($this->once())
            ->method('drawDom');

        $response->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo($xhtml));

        $this->object->injectResponse($event);
    }
}
