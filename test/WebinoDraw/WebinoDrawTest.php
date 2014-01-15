<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw;

use PHPUnit_Framework_Assert as PhpUnitAssert;
use DOMDocument;

/**
 * Test class for WebinoDraw.
 * Generated by PHPUnit on 2013-03-19 at 07:14:17.
 */
class WebinoDrawTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WebinoDraw
     */
    protected $object;

    /**
     * @var Zend\View\Renderer\PhpRenderer
     */
    protected $renderer;

    /**
     * @var WebinoDraw\WebinoDrawOptions
     */
    protected $options;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->renderer = $this->getMock('Zend\View\Renderer\PhpRenderer', array(), array(), '', false, false);
        $this->options  = $this->getMock('WebinoDraw\WebinoDrawOptions');
        $this->object   = new WebinoDraw($this->renderer, $this->options);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\WebinoDraw::setOptions
     */
    public function testSetOptions()
    {
        $options = $this->getMock('WebinoDraw\WebinoDrawOptions');

        // test fluent
        $this->assertSame($this->object, $this->object->setOptions($options));

        $this->assertSame($options, PhpUnitAssert::readAttribute($this->object, 'options'));
    }

    /**
     * @covers WebinoDraw\WebinoDraw::getOptions
     */
    public function testGetOptions()
    {
        $this->assertSame($this->options, $this->object->getOptions());

        $options = $this->getMock('WebinoDraw\WebinoDrawOptions');

        $attribute = new \ReflectionProperty($this->object, 'options');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $options);

        $this->assertSame($options, $this->object->getOptions());
    }

    /**
     * @covers WebinoDraw\WebinoDraw::setInstructions
     */
    public function testSetInstructions()
    {
        $instructions = array('test' => array());

        $this->options
            ->expects($this->once())
            ->method('setInstructions')
            ->with($this->equalTo($instructions));

        // test fluent
        $this->assertSame($this->object, $this->object->setInstructions($instructions));
    }

    /**
     * @covers WebinoDraw\WebinoDraw::getInstructions
     */
    public function testGetInstructions()
    {
        $instructions = array('test' => array());

        $this->options
            ->expects($this->once())
            ->method('getInstructions')
            ->will($this->returnValue($instructions));

        $this->assertSame($instructions, $this->object->getInstructions());
    }

    /**
     * @covers WebinoDraw\WebinoDraw::clearInstructions
     */
    public function testClearInstructions()
    {
        $this->options
            ->expects($this->once())
            ->method('clearInstructions');

        // test fluent
        $this->assertSame($this->object, $this->object->clearInstructions());
    }

    /**
     * @covers WebinoDraw\WebinoDraw::instructionsFromSet
     */
    public function testInstructionsFromSet()
    {
        $key          = 'testset';
        $instructions = array('test' => array());

        $this->options
            ->expects($this->once())
            ->method('instructionsFromSet')
            ->with($this->equalTo($key))
            ->will($this->returnValue($instructions));

        $this->assertSame($instructions, $this->object->instructionsFromSet($key));
    }

    /**
     * @covers WebinoDraw\WebinoDraw::createDom
     */
    public function testCreateDom()
    {
        $xhtml = '<xhtml/>';

        $dom = $this->object->createDom($xhtml);

        $this->assertThat($dom, $this->isInstanceOf('DOMDocument'));
        $this->assertThat($dom->xpath, $this->isInstanceOf('DOMXPath'));
    }

    /**
     * @covers WebinoDraw\WebinoDraw::drawDom
     */
    public function testDrawDom()
    {
        $element      = $this->getMock('DOMElement', array(), array(), '', false);
        $instructions = $this->getMock('WebinoDraw\Stdlib\DrawInstructions');
        $vars         = array('var' => 'val');

        $instructions->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo($element),
                $this->equalTo($this->renderer),
                $this->equalTo($vars)
            );

        // test fluent
        $this->assertSame($this->object, $this->object->drawDom($element, $instructions, $vars));
    }

    /**
     * @covers WebinoDraw\WebinoDraw::draw
     */
    public function testDraw()
    {
        $xhtml      = '<!DOCTYPE html><xhtml/>';
        $savedXhtml = '<!DOCTYPE html>' . PHP_EOL . '<html><body><xhtml></xhtml></body></html>' . PHP_EOL;
        $dom        = new DOMDocument;

        $dom->loadHTML($xhtml);

        $element      = $dom->documentElement;
        $instructions = $this->getMock('WebinoDraw\Stdlib\DrawInstructions');
        $vars         = array('var' => 'val');

        $instructions->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf('DOMElement'),
                $this->equalTo($this->renderer),
                $this->equalTo($vars)
            );

        $this->assertEquals($savedXhtml, $this->object->draw($xhtml, $instructions, $vars));
    }
}
