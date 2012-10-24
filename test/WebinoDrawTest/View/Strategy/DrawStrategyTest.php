<?php
/**
 * Webino (http://zf.webino.org/)
 *
 * @copyright   Copyright (c) 2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license     New BSD License
 * @package     WebinoDraw
 */

namespace WebinoDrawTest\View\Strategy;

use WebinoDraw\View\Strategy\DrawStrategy;
use WebinoDrawTest\TestCase;

/**
 * @category    Webino
 * @package     WebinoDraw
 * @subpackage  UnitTests
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class DrawStrategyTest extends TestCase
{
    protected $draw;
    protected $drawMock;
    protected $rendererMock;

    protected function setUp()
    {
        $this->rendererMock = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $this->drawMock     = $this->getMock('WebinoDraw\Dom\Draw', array(), array(), '', null);
        $this->draw         = new DrawStrategy($this->drawMock);
    }

    public function testGetInstructionsReturnArray()
    {
        $this->assertTrue(is_array($this->draw->getInstructions()));
    }

    public function testSetInstructionsSpecExpectArray()
    {
        $this->setExpectedException('WebinoDraw\Exception\InvalidInstructionException');

        $instructions = array('invalid_instruction');
        $this->draw->setInstructions($instructions);
    }

    public function testSetInstructions()
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
        $this->draw->setInstructions($instructions);
        $_instructions = $this->draw->getInstructions();
        $this->assertEquals(
            array($expectFirst, $expectSecond),
            array(
                $_instructions[DrawStrategy::STACK_SPACER],
                $_instructions[DrawStrategy::STACK_SPACER*2]
            )
        );
        $this->draw->setInstructions($expectFirst);
        $this->draw->setInstructions($expectSecond);
        $_instructions = $this->draw->getInstructions();
        $this->assertEquals(
            $expectFirst, $_instructions[DrawStrategy::STACK_SPACER]
        );
        $this->assertEquals(
            $expectSecond, $_instructions[DrawStrategy::STACK_SPACER*2]
        );
    }

    public function testSetInstructionsWithStackIndex()
    {
        $testIndex    = 0;
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
        $this->setExpectedException('WebinoDraw\Exception\InvalidInstructionException');

        $testIndex    = 30;
        $instructions = array('instruction_node' => array(
            'stackIndex' => $testIndex
        ));
        $this->draw->setInstructions($instructions);
        $instructions = array('instruction_node2' => array(
            'stackIndex' => $testIndex
        ));
        $this->draw->setInstructions($instructions);
    }

    public function testSetInstructionsOverrideStackIndexThrowException()
    {
        $this->setExpectedException('WebinoDraw\Exception\InvalidInstructionException');

        $testIndex    = 20;
        $instructions = array('instruction_node' => array(
            'stackIndex' => $testIndex
        ));
        $this->draw->setInstructions($instructions);
        $instructions = array('instruction_node2' => array(
            'option' => 'value2',
        ));
        $this->draw->setInstructions($instructions);
    }

    public function testSetInstructionsMerge()
    {
        $testIndex = 0;
        $expected  = $instructions = array('instruction_node' => array(
            'first_option' => 'first_option_value'
        ));
        $this->draw->setInstructions($instructions);
        $instructions = array('instruction_node' => array(
            'second_option' => 'second_option_value'
        ));
        $this->draw->setInstructions($instructions);
        $expected = array_replace_recursive($expected, $instructions);
        $this->assertEquals($expected, current($this->draw->getInstructions()));
    }

    public function testSetInstructionsMergeWidthStackIndex()
    {
        $testIndex = 0;
        $expected  = $instructions = array('instruction_node' => array(
            'stackIndex'   => $testIndex,
            'first_option' => 'first_option_value'
        ));
        $this->draw->setInstructions($instructions);
        $instructions = array('instruction_node' => array(
            'stackIndex'    => $testIndex,
            'second_option' => 'second_option_value'
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
        //todo: assert attached last?
    }

    public function testInjectResponse()
    {
        $variablesMock = $this->getMock('\ArrayObject');
        $variablesMock->expects($this->once())
            ->method('getArrayCopy')
            ->will($this->returnValue(array()));

        $childVariablesMock = $this->getMock('\ArrayObject');
        $childVariablesMock->expects($this->exactly(2))
            ->method('getArrayCopy')
            ->will($this->returnValue(array()));

        $childModelMock = $this->getMock('Zend\View\Model\ViewModel');
        $childModelMock->expects($this->exactly(2))
            ->method('getVariables')
            ->will($this->returnValue($childVariablesMock));

        $childModelMocks   = new \ArrayObject;
        $childModelMocks[] = $childModelMock;
        $childModelMocks[] = $childModelMock;

        $modelMock = $this->getMock('Zend\View\Model\ViewModel');
        $modelMock->expects($this->once())
            ->method('getVariables')
            ->will($this->returnValue($variablesMock));
        $modelMock->expects($this->once())
            ->method('getChildren')
            ->will($this->returnValue($childModelMocks));

        $responseBody = '<element/>';

        $this->drawMock->expects($this->once())
            ->method('drawXhtml')
            ->will($this->returnValue($responseBody));

        $responseMock = $this->getMock('Zend\Http\Response');
        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($responseBody));
        $responseMock->expects($this->once())
            ->method('setContent')
            ->with($this->logicalOr(
                $this->matches(true), $this->matches($responseBody)
            ));

        $eventMock = $this->getMock('Zend\View\ViewEvent');
        $eventMock->expects($this->any())
            ->method('getRenderer')
            ->will($this->returnValue($this->rendererMock));
        $eventMock->expects($this->once())
            ->method('getModel')
            ->will($this->returnValue($modelMock));
        $eventMock->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($responseMock));

        $this->draw->injectResponse($eventMock);
    }

    public function testInjectResponseWithArrayChildVariables()
    {
        $variablesMock = $this->getMock('\ArrayObject');
        $variablesMock->expects($this->once())
            ->method('getArrayCopy')
            ->will($this->returnValue(array()));

        $childModelMock = $this->getMock('Zend\View\Model\ViewModel');
        $childModelMock->expects($this->exactly(2))
            ->method('getVariables')
            ->will($this->returnValue(array()));

        $childModelMocks   = new \ArrayObject;
        $childModelMocks[] = $childModelMock;
        $childModelMocks[] = $childModelMock;

        $modelMock = $this->getMock('Zend\View\Model\ViewModel');
        $modelMock->expects($this->once())
            ->method('getVariables')
            ->will($this->returnValue($variablesMock));
        $modelMock->expects($this->once())
            ->method('getChildren')
            ->will($this->returnValue($childModelMocks));

        $responseBody = '<element/>';

        $this->drawMock->expects($this->once())
            ->method('drawXhtml')
            ->will($this->returnValue($responseBody));

        $responseMock = $this->getMock('Zend\Http\Response');
        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($responseBody));
        $responseMock->expects($this->once())
            ->method('setContent')
            ->with($this->logicalOr(
                $this->matches(true), $this->matches($responseBody)
            ));

        $eventMock = $this->getMock('Zend\View\ViewEvent');
        $eventMock->expects($this->any())
            ->method('getRenderer')
            ->will($this->returnValue($this->rendererMock));
        $eventMock->expects($this->once())
            ->method('getModel')
            ->will($this->returnValue($modelMock));
        $eventMock->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($responseMock));

        $this->draw->injectResponse($eventMock);
    }

    public function testInjectResponseDisabledWithJsonRenderer()
    {
        $rendererMock = $this->getMock('Zend\View\Renderer\JsonRenderer');

        $responseMock = $this->getMock('Zend\Http\Response');
        $responseMock->expects($this->never())
            ->method('setContent');

        $eventMock = $this->getMock('Zend\View\ViewEvent');
        $eventMock->expects($this->any())
            ->method('getRenderer')
            ->will($this->returnValue($rendererMock));
        $eventMock->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($responseMock));

        $this->draw->injectResponse($eventMock);
    }

    public function testInjectResponseDisabledWithEmptyResult()
    {
        $registryMock = $this->getMock('Zend\View\Helper\Placeholder\Registry');
        $registryMock->expects($this->any())
            ->method('containerExists')
            ->will($this->returnValue(false));

        $responseMock = $this->getMock('Zend\Http\Response');
        $responseMock->expects($this->never())
            ->method('setContent');
        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(null));

        $eventMock = $this->getMock('Zend\View\ViewEvent');
        $eventMock->expects($this->any())
            ->method('getRenderer')
            ->will($this->returnValue($this->rendererMock));
        $eventMock->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($responseMock));

        $this->draw->injectResponse($eventMock);
    }
}
