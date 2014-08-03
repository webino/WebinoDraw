<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Form\View\Helper;

/**
 * Test class for FormElement.
 * Generated by PHPUnit on 2013-04-21 at 22:28:04.
 */
class FormElementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormElement
     */
    protected $object;
    protected $view;
    protected $element;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new FormElement;

        $this->view = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $this->object->setView($this->view);

        $this->element = $this->getMock('Zend\Form\Element');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\Form\View\Helper\FormElement::resolveHelper
     * @todo Implement testResolveHelper().
     */
    public function testResolveHelper()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers WebinoDraw\Form\View\Helper\FormElement::resolveHelper
     */
    public function testResolveHelperByOption()
    {
        $expected   = $this->getMock('Zend\Form\View\Helper\FormElement');
        $viewHelper = 'test_view_helper';

        $this->element->expects($this->once())
            ->method('getOption')
            ->with('view_helper')
            ->will($this->returnValue($viewHelper));

        $this->view->expects($this->once())
            ->method('plugin')
            ->with($this->equalTo($viewHelper))
            ->will($this->returnValue($expected));

        $result = $this->object->resolveHelper($this->element);

        $this->assertSame($result, $expected);
    }

    /**
     * @covers WebinoDraw\Form\View\Helper\FormElement::resolveHelper
     */
    public function testResolveHelperByEmptyOption()
    {
        $this->setExpectedException('OutOfRangeException');

        $viewHelper = '';

        $this->element->expects($this->once())
            ->method('getOption')
            ->with('view_helper')
            ->will($this->returnValue($viewHelper));

        $this->view->expects($this->never())
            ->method('plugin');

        $this->object->resolveHelper($this->element);
    }

    /**
     * @covers WebinoDraw\Form\View\Helper\FormElement::render
     * @todo Implement testRender().
     */
    public function testRender()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers WebinoDraw\Form\View\Helper\FormElement::__invoke
     * @todo Implement testInvoke().
     */
    public function testInvoke()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
