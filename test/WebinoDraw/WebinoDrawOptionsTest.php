<?php

namespace WebinoDraw;

/**
 * Test class for WebinoDrawOptions.
 * Generated by PHPUnit on 2013-03-19 at 08:25:18.
 */
class WebinoDrawOptionsTest
        extends \PHPUnit_Framework_TestCase
{

    /**
     * @var WebinoDrawOptions
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new WebinoDrawOptions;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::setInstructions
     */
    public function testSetInstructions()
    {
        $instructions = array('test' => array());

        $drawInstructions = $this->getMock('WebinoDraw\Stdlib\DrawInstructions');

        $this->object->setInstructions($drawInstructions);

        $drawInstructions
            ->expects($this->once())
            ->method('merge')
            ->with($this->equalTo($instructions));

        // test fluent
        $this->assertSame($this->object, $this->object->setInstructions($instructions));

        $this->assertSame(
            $drawInstructions,
            \PHPUnit_Framework_Assert::readAttribute($this->object, 'instructions')
        );
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::setInstructions
     */
    public function testSetInstructionsCreate()
    {
        $instructions = array('test' => array());

        // test fluent
        $this->assertSame($this->object, $this->object->setInstructions($instructions));

        $this->assertThat(
            \PHPUnit_Framework_Assert::readAttribute($this->object, 'instructions'),
            $this->isInstanceOf('WebinoDraw\Stdlib\DrawInstructions')
        );
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::getInstructions

     */
    public function testGetInstructions()
    {
        $this->assertThat(
            $this->object->getInstructions(),
            $this->isInstanceOf('WebinoDraw\Stdlib\DrawInstructionsInterface')
        );

        $instructions = $this->getMock('WebinoDraw\Stdlib\DrawInstructions');

        $attribute = new \ReflectionProperty($this->object, 'instructions');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $instructions);

        $this->assertSame($instructions, $this->object->getInstructions());
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::clearInstructions
     */
    public function testClearInstructions()
    {
        // test fluent
        $this->assertSame($this->object, $this->object->clearInstructions());

        $this->assertSame(
            null,
            \PHPUnit_Framework_Assert::readAttribute($this->object, 'instructions')
        );
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::setInstructionSet
     */
    public function testSetInstructionSet()
    {
        $instructionSet = array('testset' => array());

        // test fluent
        $this->assertSame($this->object, $this->object->setInstructionSet($instructionSet));

        $this->assertSame(
            $instructionSet,
            \PHPUnit_Framework_Assert::readAttribute($this->object, 'instructionSet')
        );
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::getInstructionSet
     */
    public function testGetInstructionSet()
    {
        $this->assertSame(array(), $this->object->getInstructionSet());

        $instructionSet = array('testset' => array());

        $attribute = new \ReflectionProperty($this->object, 'instructionSet');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $instructionSet);

        $this->assertSame($instructionSet, $this->object->getInstructionSet());
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::instructionsFromSet
     */
    public function testInstructionsFromSet()
    {
        $this->assertSame(array(), $this->object->instructionsFromSet('unknown'));

        $instructionSet = array('testset' => array('testinstructions' => array()));

        $attribute = new \ReflectionProperty($this->object, 'instructionSet');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $instructionSet);

        $this->assertSame($instructionSet['testset'], $this->object->instructionsFromSet('testset'));
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::setAjaxContainerXpath
     */
    public function testSetAjaxContainerXpath()
    {
        $xpath = '//test';

        // test fluent
        $this->assertSame($this->object, $this->object->setAjaxContainerXpath($xpath));

        $this->assertEquals(
            $xpath,
            \PHPUnit_Framework_Assert::readAttribute($this->object, 'ajaxContainerXpath')
        );
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::getAjaxContainerXpath
     */
    public function testGetAjaxContainerXpath()
    {
        $this->assertEquals('//body', $this->object->getAjaxContainerXpath());

        $xpath = '//test';

        $attribute = new \ReflectionProperty($this->object, 'ajaxContainerXpath');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $xpath);

        $this->assertSame($xpath, $this->object->getAjaxContainerXpath());
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::setAjaxFragmentXpath
     */
    public function testSetAjaxFragmentXpath()
    {
        $xpath = '//test';

        // test fluent
        $this->assertSame($this->object, $this->object->setAjaxFragmentXpath($xpath));

        $this->assertEquals(
            $xpath,
            \PHPUnit_Framework_Assert::readAttribute($this->object, 'ajaxFragmentXpath')
        );
    }

    /**
     * @covers WebinoDraw\WebinoDrawOptions::getAjaxFragmentXpath
     */
    public function testGetAjaxFragmentXpath()
    {
        $this->assertEquals(
            '//*[contains(@class, "ajax-fragment") and @id]',
            $this->object->getAjaxFragmentXpath()
        );

        $xpath = '//test';

        $attribute = new \ReflectionProperty($this->object, 'ajaxFragmentXpath');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $xpath);

        $this->assertSame($xpath, $this->object->getAjaxFragmentXpath());
    }
}