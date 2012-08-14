<?php
/**
 * Webino (http://zf.webino.org/)
 *
 * @copyright   Copyright (c) 2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license     New BSD License
 * @package     WebinoDraw
 */

namespace WebinoDrawTest\View\Strategy;

use Webino\View\Strategy\DrawStrategy;
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
    protected $rendererMock;

    protected function setUp()
    {
        $this->rendererMock = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $this->draw         = new DrawStrategy($this->rendererMock);
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
        $this->setExpectedException('Webino\Draw\Exception\InvalidInstructionException');

        $testIndex    = 0;
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

    public function testDrawEmptyThrowsException()
    {
        $this->setExpectedException('Webino\Draw\Exception\InvalidArgumentException');

        $xhtml        = '';
        $instructions = array();
        $this->draw->draw($xhtml, $instructions);
    }

    public function testDraw()
    {
        $xhtml        = '<div/>';
        $instructions = array();
        $expected = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">'
                    . PHP_EOL . '<html><body><div></div></body></html>' . PHP_EOL;
        $this->assertEquals($expected, $this->draw->draw($xhtml, $instructions));
    }

    public function testDrawHTML5()
    {
        $xhtml        = '<!DOCTYPE html><html><body><article/></body></html>';
        $instructions = array();
        $expected = '<!DOCTYPE html>'
                    . PHP_EOL . '<html><body><article></article></body></html>' . PHP_EOL;

        $this->assertEquals($expected, $this->draw->draw($xhtml, $instructions));
    }

    public function testDrawDomDocumentExpectsXpath()
    {
        $this->setExpectedException('Webino\Draw\Exception\InvalidArgumentException');
        $this->draw->drawDomDocument(new \DOMDocument, array(), array());
    }

    public function testDrawDomDocumentSingleNode()
    {
        $xhtml = '<test_node/>';
        $doc   = new \DOMDocument;
        $doc->loadXML($xhtml);
        $doc->xpath = new \DOMXPath($doc);

        $instructions = array(
            array(
                'test_node' => array(
                    'xpath'  => '.',
                    'helper' => 'DrawElement'
                )
            ),
        );
        $vars = array();

        $drawHelperMock = $this->getMock('Webino\Draw\Helper\Element');
        $drawHelperMock->expects($this->once())
            ->method('setVars')
            ->with($vars);
        $drawHelperMock->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->isInstanceOf('Webino\Draw\NodeList'),
                $instructions[0]['test_node']
            );

        $this->rendererMock->expects($this->once())
            ->method('plugin')
            ->with($instructions[0]['test_node']['helper'])
            ->will($this->returnValue($drawHelperMock));

        $this->draw->drawDomDocument($doc, $instructions, $vars);
    }

    public function testDrawDomDocument()
    {
        $xhtml = '<test_node/>';
        $doc   = new \DOMDocument;
        $doc->loadXML($xhtml);
        $doc->xpath = new \DOMXPath($doc);

        $instructions = array(
            array(
                'test_node' => array(
                    'xpath'  => '.',
                    'helper' => 'DrawElement'
                )
            ),
            array(
                'test_node2' => array(
                    'xpath'  => '.',
                    'helper' => 'DrawElement'
                )
            )
        );
        $vars = array();

        $drawHelperMock = $this->getMock('Webino\Draw\Helper\Element');
        $drawHelperMock->expects($this->exactly(2))
            ->method('setVars')
            ->with($vars);
        $drawHelperMock->expects($this->exactly(2))
            ->method('__invoke')
            ->with(
                $this->isInstanceOf('Webino\Draw\NodeList'),
                $instructions[0]['test_node']
            );

        $this->rendererMock->expects($this->exactly(2))
            ->method('plugin')
            ->with($instructions[0]['test_node']['helper'])
            ->will($this->returnValue($drawHelperMock));

        $this->draw->drawDomDocument($doc, $instructions, $vars);
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
        $expectedBody = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">'
                    . PHP_EOL . '<html><body><element></element></body></html>' . PHP_EOL;

        $responseMock = $this->getMock('Zend\Http\Response');
        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($responseBody));
        $responseMock->expects($this->exactly(2))
            ->method('setContent')
            ->with($this->logicalOr(
                $this->matches(true), $this->matches($expectedBody)
            ));

        $eventMock = $this->getMock('Zend\View\ViewEvent');
        $eventMock->expects($this->any())
            ->method('getRenderer')
            ->will($this->returnValue($this->rendererMock));
        $eventMock->expects($this->once())
            ->method('getResult')
            ->will($this->returnValue(true));
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
        $expectedBody = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">'
                    . PHP_EOL . '<html><body><element></element></body></html>' . PHP_EOL;

        $responseMock = $this->getMock('Zend\Http\Response');
        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($responseBody));
        $responseMock->expects($this->exactly(2))
            ->method('setContent')
            ->with($this->logicalOr(
                $this->matches(true), $this->matches($expectedBody)
            ));

        $eventMock = $this->getMock('Zend\View\ViewEvent');
        $eventMock->expects($this->any())
            ->method('getRenderer')
            ->will($this->returnValue($this->rendererMock));
        $eventMock->expects($this->once())
            ->method('getResult')
            ->will($this->returnValue(true));
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

        $placeholderMock = $this->getMock('Zend\View\Helper\Placeholder');
        $placeholderMock->expects($this->once())
            ->method('getRegistry')
            ->will($this->returnValue($registryMock));

        $this->rendererMock->expects($this->once())
            ->method('plugin')
            ->with('placeholder')
            ->will($this->returnValue($placeholderMock));

        $responseMock = $this->getMock('Zend\Http\Response');
        $responseMock->expects($this->once())
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
