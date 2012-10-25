<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDrawTest\View\Strategy;

use WebinoDraw\View\Strategy\DrawStrategy;
use WebinoDrawTest\TestCase;

/**
 * Test class for WebinoDraw\Stdlib\VarTranslator.
 *
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  UnitTests
 * @group       WebinoDraw_View
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

    public function testGetInstructionsFromSet()
    {
        $instructionset = array(
            'instructionset0' => array('instructions0'),
            'instructionset1' => array('instructions1'),
            'instructionset2' => array('instructions2'),
        );

        $this->draw->setInstructionset($instructionset);

        $key      = 'instructionset0';
        $expected = $instructionset[$key];
        $actual   = $this->draw->getInstructionsFromSet($key);

        $this->assertSame($expected, $actual);

        $key      = 'instructionset1';
        $expected = $instructionset[$key];
        $actual   = $this->draw->getInstructionsFromSet($key);

        $this->assertSame($expected, $actual);

        $key      = 'instructionset2';
        $expected = $instructionset[$key];
        $actual   = $this->draw->getInstructionsFromSet($key);

        $this->assertSame($expected, $actual);
    }

    public function testGetUnknownInstructionsFromSetReturnEmptyArray()
    {
        $actual = $this->draw->getInstructionsFromSet('unknown');
        $this->assertSame(array(), $actual);
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
