<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Strategy;

use DOMDocument;
use WebinoDraw\Instructions\Instructions;
use Zend\Http\Headers as HttpHeaders;
use Zend\View\Model\ViewModel;
use Zend\View\ViewEvent;

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
     * @var \WebinoDraw\Service\DrawService
     */
    protected $service;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->service = $this->getMock('WebinoDraw\Service\DrawService', [], [], '', null);
        $this->object  = new DrawStrategy($this->service);
    }

    /**
     * @covers WebinoDraw\View\Strategy\DrawStrategy::injectResponse
     */
    public function testInjectResponse()
    {
        $response        = $this->getMock('Zend\Http\PhpEnvironment\Response');
        $responseHeaders = new HttpHeaders;
        $responseBody    = '<response_body/>';
        $options         = $this->getMock('WebinoDraw\Options\ModuleOptions');
        $instructions    = new Instructions;
        $xhtml           = '<xhtml></xhtml>' . PHP_EOL;
        $dom             = new DOMDocument;
        $dom->loadXML($xhtml);
        $model           = new ViewModel;
        $event           = new ViewEvent;

        $event
            ->setRenderer(new \Zend\View\Renderer\PhpRenderer)
            ->setResponse($response)
            ->setModel($model);

        $response->expects($this->any())
            ->method('getHeaders')
            ->will($this->returnValue($responseHeaders));

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
            ->method('draw')
            ->with($responseBody, $instructions, [], false)
            ->will($this->returnValue($xhtml));

        $response->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo($xhtml));

        $this->object->injectResponse($event);
    }
}
