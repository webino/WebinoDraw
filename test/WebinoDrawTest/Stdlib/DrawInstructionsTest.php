<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Stdlib
 */

namespace WebinoDrawTest\Stdlib;

use WebinoDraw\Stdlib\DrawInstructions;
use WebinoDrawTest\TestCase;

/**
 * Test class for WebinoDraw\Stdlib\VarTranslator.
 *
 * @category    Webino
 * @package     WebinoDraw_Stdlib
 * @subpackage  UnitTests
 * @group       WebinoDraw_Stdlib
 */
class DrawInstructionsTest extends TestCase
{
    public function testMerge()
    {
        $instructions = array(
            'instruction_node1' => array('option' => 'value1'),
            'instruction_node2' => array('option' => 'value2'),
        );
        $expectFirst = array(
            'instruction_node1' => $instructions['instruction_node1']
        );
        $expectSecond = array(
            'instruction_node2' => $instructions['instruction_node2']
        );
        $_instructions = DrawInstructions::merge(array(), $instructions);
        $this->assertEquals(
            array($expectFirst, $expectSecond),
            array(
                $_instructions[DrawInstructions::STACK_SPACER],
                $_instructions[DrawInstructions::STACK_SPACER*2]
            )
        );
        $_instructions = DrawInstructions::merge($_instructions, $expectFirst);
        $_instructions = DrawInstructions::merge($_instructions, $expectSecond);
        $this->assertEquals(
            $expectFirst, $_instructions[DrawInstructions::STACK_SPACER]
        );
        $this->assertEquals(
            $expectSecond, $_instructions[DrawInstructions::STACK_SPACER*2]
        );
    }

    public function testMergeWithStackIndex()
    {
        $testIndex    = 0;
        $instructions = array('instruction_node' => array(
            'stackIndex' => $testIndex
        ));
        $_instructions = DrawInstructions::merge(array(), $instructions);
        $this->assertArrayHasKey($testIndex, $_instructions);
        $this->assertEquals($instructions, $_instructions[$testIndex]);
    }

    public function testMergeWithLowerStackIndex()
    {
        $_instructions = DrawInstructions::merge(array(), array('instruction_node0' => array()));
        $_instructions = DrawInstructions::merge(array(), array('instruction_node1' => array()));
        $_instructions = DrawInstructions::merge(array(), array('instruction_node2' => array()));
        $instructions = array('instruction_nodeX' => array(
            'stackIndex' => 1
        ));
        $_instructions = DrawInstructions::merge($_instructions, $instructions);
        $this->assertArrayHasKey(1, $_instructions);
        $this->assertEquals($instructions, $_instructions[1]);
    }

    public function testMergeWithSameStackIndexThrowException()
    {
        $this->setExpectedException('WebinoDraw\Exception\InvalidInstructionException');

        $testIndex    = 30;
        $instructions = array('instruction_node' => array(
            'stackIndex' => $testIndex
        ));
        $_instructions = DrawInstructions::merge(array(), $instructions);
        $instructions = array('instruction_node2' => array(
            'stackIndex' => $testIndex
        ));
        DrawInstructions::merge($_instructions, $instructions);
    }

    public function testMergeOverrideStackIndexThrowException()
    {
        $this->setExpectedException('WebinoDraw\Exception\InvalidInstructionException');

        $testIndex    = 20;
        $instructions = array('instruction_node' => array(
            'stackIndex' => $testIndex
        ));
        $_instructions = DrawInstructions::merge(array(), $instructions);
        $instructions = array('instruction_node2' => array(
            'option' => 'value2',
        ));
        DrawInstructions::merge($_instructions, $instructions);
    }

    public function testMergeMerge()
    {
        $testIndex = 0;
        $expected  = $instructions = array('instruction_node' => array(
            'first_option' => 'first_option_value'
        ));
        $_instructions = DrawInstructions::merge(array(), $instructions);
        $instructions  = array('instruction_node' => array(
            'second_option' => 'second_option_value'
        ));
        $_instructions = DrawInstructions::merge($_instructions, $instructions);
        $expected = array_replace_recursive($expected, $instructions);
        $this->assertEquals($expected, $_instructions[DrawInstructions::STACK_SPACER]);
    }

    public function testMergeMergeWidthStackIndex()
    {
        $testIndex = 0;
        $expected  = $instructions = array('instruction_node' => array(
            'stackIndex'   => $testIndex,
            'first_option' => 'first_option_value'
        ));
        $_instructions = DrawInstructions::merge(array(), $instructions);
        $instructions  = array('instruction_node' => array(
            'stackIndex'    => $testIndex,
            'second_option' => 'second_option_value'
        ));
        $_instructions = DrawInstructions::merge($_instructions, $instructions);
        $expected = array($testIndex => array_replace_recursive($expected, $instructions));
        $this->assertEquals($expected, $_instructions);
    }
}
