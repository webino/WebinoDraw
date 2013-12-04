<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw;

use PHPUnit_Framework_Assert as PhpUnitAssert;
use ReflectionProperty;

/**
 * Test class for DrawEvent.
 * Generated by PHPUnit on 2013-03-19 at 09:07:57.
 */
class DrawEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DrawEvent
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new DrawEvent;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\DrawEvent::setNodes
     */
    public function testSetNodes()
    {
        $nodes = $this->getMock('WebinoDraw\Dom\NodeList');

        // test fluent
        $this->assertSame($this->object, $this->object->setNodes($nodes));

        $this->assertSame($nodes, $this->object->getParam('nodes'));
        $this->assertSame($nodes, PhpUnitAssert::readAttribute($this->object, 'nodes'));
    }

    /**
     * @covers WebinoDraw\DrawEvent::getNodes
     */
    public function testGetNodes()
    {
        $this->assertThat(
            $this->object->getNodes(),
            $this->isInstanceOf('WebinoDraw\Dom\NodeList')
        );

        $nodes = $this->getMock('WebinoDraw\Dom\NodeList');

        $attribute = new ReflectionProperty($this->object, 'nodes');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $nodes);

        $this->assertSame($nodes, $this->object->getNodes());
    }

    /**
     * @covers WebinoDraw\DrawEvent::setSpec
     */
    public function testSetSpec()
    {
        $spec = array(array('rewritten'));

        $targetSpec = array(array('torewrite'), 'original');
        $mergedSpec = array(array('rewritten'), 'original');

        $specObject = $this->getMock('ArrayObject');

        $specObject->expects($this->once())
            ->method('getArrayCopy')
            ->will($this->returnValue($targetSpec));

        $specObject->expects($this->once())
            ->method('exchangeArray')
            ->with($this->equalTo($mergedSpec));

        $this->object->setSpec($specObject);

        // test fluent
        $this->assertSame($this->object, $this->object->setSpec($spec));

        $this->assertSame($specObject, $this->object->getParam('spec'));
        $this->assertSame($specObject, PhpUnitAssert::readAttribute($this->object, 'spec'));
    }

    /**
     * @covers WebinoDraw\DrawEvent::setSpec
     */
    public function testSetSpecCreate()
    {
        $spec = array(array('rewritten'));

        // test fluent
        $this->assertSame($this->object, $this->object->setSpec($spec));

        $this->assertThat(
            $this->object->getParam('spec'),
            $this->isInstanceOf('ArrayObject')
        );

        $this->assertThat(
            PhpUnitAssert::readAttribute($this->object, 'spec'),
            $this->isInstanceOf('ArrayObject')
        );
    }

    /**
     * @covers WebinoDraw\DrawEvent::getSpec
     */
    public function testGetSpec()
    {
        $this->assertThat(
            $this->object->getSpec(),
            $this->isInstanceOf('ArrayObject')
        );

        $spec = $this->getMock('ArrayObject');

        $attribute = new ReflectionProperty($this->object, 'spec');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $spec);

        $this->assertSame($spec, $this->object->getSpec());
    }

    /**
     * @covers WebinoDraw\DrawEvent::clearSpec
     */
    public function testClearSpec()
    {
        // test fluent
        $this->assertSame($this->object, $this->object->clearSpec());

        $this->assertSame(null, PhpUnitAssert::readAttribute($this->object, 'spec'));
    }
}
