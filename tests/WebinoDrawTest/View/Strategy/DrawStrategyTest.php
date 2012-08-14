<?php

namespace WebinoDrawTest\View\Strategy;

use Webino\View\Strategy\DrawStrategy;
use WebinoDrawTest\TestCase;

class DrawStrategyTest extends TestCase
{
    protected $draw;

    protected function setUp()
    {
        $rendererMock = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $this->draw   = new DrawStrategy($rendererMock);
    }

    public function testGetInstructionsReturnArray()
    {
        $this->assertTrue(is_array($this->draw->getInstructions()));
    }

    public function testSetInstructionsSpecExpectArray()
    {
        $this->setExpectedException('Webino\Draw\Exception\InvalidInstructionException');

        $instructions = array('invalid_instruction');
        $this->draw->setInstructions($instructions);
    }

    public function testSetInstructions()
    {
        $instructions = array('instruction_node' => array());
        $this->draw->setInstructions($instructions);
        $_instructions = $this->draw->getInstructions();
        $this->assertEquals($instructions, $_instructions[DrawStrategy::STACK_SPACER]);
    }

    public function testSetInstructionsWithStackIndex()
    {
        $testIndex    = rand(0, 999);
        $instructions = array('instruction_node' => array(
            'stackIndex' => $testIndex
        ));
        $this->draw->setInstructions($instructions);
        $_instructions = $this->draw->getInstructions();
        $this->assertArrayHasKey($testIndex, $_instructions);
        $this->assertEquals($instructions, $_instructions[$testIndex]);
    }

    public function testSetInstructionsWithLowerStackIndex()
    {
        $this->draw->setInstructions(array('instruction_node0' => array()));
        $this->draw->setInstructions(array('instruction_node1' => array()));
        $this->draw->setInstructions(array('instruction_node2' => array()));
        $instructions = array('instruction_nodeX' => array(
            'stackIndex' => 1
        ));
        $this->draw->setInstructions($instructions);
        $_instructions = $this->draw->getInstructions();
        $this->assertArrayHasKey(1, $_instructions);
        $this->assertEquals($instructions, $_instructions[1]);
    }

    public function testSetInstructionsWithSameStackIndexThrowException()
    {
        $this->setExpectedException('Webino\Draw\Exception\InvalidInstructionException');

        $testIndex    = rand(0, 999);
        $instructions = array('instruction_node' => array(
            'stackIndex' => $testIndex
        ));
        $this->draw->setInstructions($instructions);
        $instructions = array('instruction_node2' => array(
            'stackIndex' => $testIndex
        ));
        $this->draw->setInstructions($instructions);
    }

    public function testSetInstructionsMerge()
    {
        $testIndex = rand(0, 999);
        $expected  = $instructions = array('instruction_node' => array(
            'first_option' => md5(uniqid(rand()))
        ));
        $this->draw->setInstructions($instructions);
        $instructions = array('instruction_node' => array(
            'second_option' => md5(uniqid(rand()))
        ));
        $this->draw->setInstructions($instructions);
        $expected = array_replace_recursive($expected, $instructions);
        $this->assertEquals($expected, current($this->draw->getInstructions()));
    }
    
    public function testSetInstructionsMergeWidthStackIndex()
    {
        $testIndex = rand(0, 999);
        $expected  = $instructions = array('instruction_node' => array(
            'stackIndex'   => $testIndex,
            'first_option' => md5(uniqid(rand()))
        ));
        $this->draw->setInstructions($instructions);
        $instructions = array('instruction_node' => array(
            'stackIndex'    => $testIndex,
            'second_option' => md5(uniqid(rand()))
        ));
        $this->draw->setInstructions($instructions);
        $expected = array(
            $testIndex => array_replace_recursive($expected, $instructions)
        );
        $this->assertEquals($expected, $this->draw->getInstructions());
    }

    public function testClearInstructions()
    {
        $this->assertEmpty($this->draw->getInstructions());
        $instructions = array('instruction_node' => array());
        $this->draw->setInstructions($instructions);
        $this->draw->clearInstructions();
        $this->assertEmpty($this->draw->getInstructions());
    }

    public function testAttachLast()
    {
        $eventsMock = $this->getMock('Zend\EventManager\EventManager');

        $this->draw->attach($eventsMock);
    }

    public function testDraw()
    {
        $this->markTestIncomplete("Not finished");
    }

    public function testDrawDomDocument()
    {
        $this->markTestIncomplete("Not finished");
    }

    public function testInjectResponse()
    {
        $this->markTestIncomplete("Not finished");
    }
}
