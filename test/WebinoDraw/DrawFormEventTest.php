<?php

namespace WebinoDraw;

/**
 * Test class for DrawFormEvent.
 * Generated by PHPUnit on 2013-03-19 at 11:57:57.
 */
class DrawFormEventTest
        extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DrawFormEvent
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new DrawFormEvent;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\DrawFormEvent::setForm
     */
    public function testSetForm()
    {
        $form = $this->getMock('Zend\Form\Form');

        // test fluent
        $this->assertSame($this->object, $this->object->setForm($form));

        $this->assertEquals(
            $form,
            $this->object->getParam('form')
        );

        $this->assertEquals(
            $form,
            \PHPUnit_Framework_Assert::readAttribute($this->object, 'form')
        );
    }

    /**
     * @covers WebinoDraw\DrawFormEvent::getForm
     */
    public function testGetForm()
    {
        $this->assertThat(
            $this->object->getForm(),
            $this->isInstanceOf('Zend\Form\FormInterface')
        );

        $form = $this->getMock('Zend\Form\Form');

        $attribute = new \ReflectionProperty($this->object, 'form');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $form);

        $this->assertSame($form, $this->object->getForm());
    }
}