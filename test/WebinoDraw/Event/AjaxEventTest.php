<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Event;

use PHPUnit_Framework_Assert as PhpUnitAssert;
use ReflectionProperty;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-07-31 at 12:10:16.
 */
class AjaxEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AjaxEvent
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new AjaxEvent;
    }

    /**
     * @covers WebinoDraw\Event\AjaxEvent::getJson
     */
    public function testGetJson()
    {
        $this->assertThat(
            $this->object->getJson(),
            $this->isInstanceOf('WebinoDraw\Ajax\Json')
        );

        $json = $this->getMock('WebinoDraw\Ajax\Json');

        $attribute = new ReflectionProperty($this->object, 'json');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $json);

        $this->assertSame($json, $this->object->getJson());
    }

    /**
     * @covers WebinoDraw\Event\AjaxEvent::setJson
     */
    public function testSetJson()
    {
        $json = ['var' => 'val'];

        $ajaxJson = $this->getMock('WebinoDraw\Ajax\Json');

        $ajaxJson->expects($this->once())
            ->method('merge')
            ->with($this->equalTo($json));

        $this->object->setJson($ajaxJson);

        // test fluent
        $this->assertSame($this->object, $this->object->setJson($json));

        $this->assertSame(
            $ajaxJson,
            $this->object->getParam('json')
        );

        $this->assertSame(
            $ajaxJson,
            PhpUnitAssert::readAttribute($this->object, 'json')
        );
    }

    /**
     * @covers WebinoDraw\Event\AjaxEvent::setJson
     */
    public function testSetJsonCreate()
    {
        $json = ['var' => 'val'];

        // test fluent
        $this->assertSame($this->object, $this->object->setJson($json));

        $this->assertThat(
            $this->object->getParam('json'),
            $this->isInstanceOf('WebinoDraw\Ajax\Json')
        );

        $this->assertThat(
            PhpUnitAssert::readAttribute($this->object, 'json'),
            $this->isInstanceOf('WebinoDraw\Ajax\Json')
        );
    }

    /**
     * @covers WebinoDraw\Event\AjaxEvent::getFragmentXpath
     * @todo   Implement testGetFragmentXpath().
     */
    public function testGetFragmentXpath()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers WebinoDraw\Event\AjaxEvent::setFragmentXpath
     */
    public function testSetFragmentXpath()
    {
        $xpath = '//test';

        $xpathObject = $this->getMock('WebinoDraw\Ajax\FragmentXpath');

        $xpathObject->expects($this->once())
            ->method('set')
            ->with($this->equalTo($xpath));

        $this->object->setFragmentXpath($xpathObject);

        // test fluent
        $this->assertSame($this->object, $this->object->setFragmentXpath($xpath));

        $this->assertSame($xpathObject, $this->object->getParam('fragmentXpath'));
        $this->assertSame(
            $xpathObject,
            PhpUnitAssert::readAttribute($this->object, 'fragmentXpath')
        );
    }

    /**
     * @covers WebinoDraw\Event\AjaxEvent::setFragmentXpath
     */
    public function testSetFragmentXpathCreate()
    {
        $xpath = '//test';

        // test fluent
        $this->assertSame($this->object, $this->object->setFragmentXpath($xpath));

        $this->assertThat(
            $this->object->getParam('fragmentXpath'),
            $this->isInstanceOf('WebinoDraw\Ajax\FragmentXpath')
        );

        $this->assertThat(
            PhpUnitAssert::readAttribute($this->object, 'fragmentXpath'),
            $this->isInstanceOf('WebinoDraw\Ajax\FragmentXpath')
        );
    }
}