<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Instructions;

/**
 * Test class for Instructions.
 * Generated by PHPUnit on 2013-03-18 at 13:49:38.
 */
class InstructionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Instructions
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Instructions;
    }

    /**
     * @covers WebinoDraw\Instructions\Instructions::exchangeArray
     * @todo Implement testExchangeArray().
     */
    public function testExchangeArray()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * Tests that instructions are placed into the stack with the right index
     *
     * Basically tests the instructions structure
     * after using the merge method.
     *
     * @covers WebinoDraw\Instructions\Instructions::merge
     */
    public function testMerge()
    {
        $instructions = [
            'instruction_node1' => ['option' => 'value1'],
            'instruction_node2' => ['option' => 'value2'],
        ];
        $expectOne = [
            'instruction_node1' => $instructions['instruction_node1']
        ];
        $expectTwo = [
            'instruction_node2' => $instructions['instruction_node2']
        ];

        $this->object->merge($instructions);

        $_instructions = $this->object->getArrayCopy();

        $this->assertEquals(
            [$expectOne, $expectTwo],
            [
                $_instructions[Instructions::STACK_SPACER],
                $_instructions[Instructions::STACK_SPACER * 2]
            ]
        );

        $this->object->merge($expectOne);
        $_instructionsOne = $this->object->getArrayCopy();

        $this->assertEquals($expectOne, $_instructionsOne[Instructions::STACK_SPACER]);

        $this->object->merge($expectTwo);
        $_instructionsTwo = $this->object->getArrayCopy();

        $this->assertEquals($expectTwo, $_instructionsTwo[Instructions::STACK_SPACER * 2]);
    }
}
