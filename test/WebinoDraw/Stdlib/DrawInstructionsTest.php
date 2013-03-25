<?php

namespace WebinoDraw\Stdlib;

/**
 * Test class for DrawInstructions.
 * Generated by PHPUnit on 2013-03-18 at 13:49:38.
 */
class DrawInstructionsTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DrawInstructions
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new DrawInstructions;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::exchangeArray
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
     * @covers WebinoDraw\Stdlib\DrawInstructions::setLocator
     */
    public function testSetLocator()
    {
        $locator = $this->getMock('WebinoDraw\Dom\Locator');

        // test fluent
        $this->assertSame($this->object, $this->object->setLocator($locator));

        $attribute = new \ReflectionProperty($this->object, 'locator');
        $attribute->setAccessible(true);

        $this->assertSame(
            $locator,
            $attribute->getValue($this->object)
        );
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::getLocator
     */
    public function testGetLocator()
    {
        $this->assertThat(
            $this->object->getLocator(),
            $this->isInstanceOf('WebinoDraw\Dom\Locator')
        );

        $locator = $this->getMock('WebinoDraw\Dom\Locator');

        $attribute = new \ReflectionProperty($this->object, 'locator');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $locator);

        $this->assertSame($locator, $this->object->getLocator());
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::setNodeListPrototype
     */
    public function testSetNodeListPrototype()
    {
        $nodeList = $this->getMock('WebinoDraw\Dom\NodeList');

        // test fluent
        $this->assertSame($this->object, $this->object->setNodeListPrototype($nodeList));

        $attribute = new \ReflectionProperty($this->object, 'nodeListPrototype');
        $attribute->setAccessible(true);

        $this->assertSame(
            $nodeList,
            $attribute->getValue($this->object)
        );
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::getNodeListPrototype
     */
    public function testGetNodeListPrototype()
    {
        $this->assertThat(
            $this->object->getNodeListPrototype(),
            $this->isInstanceOf('WebinoDraw\Dom\NodeList')
        );

        $prototype = $this->getMock('WebinoDraw\Dom\NodeList');

        $attribute = new \ReflectionProperty($this->object, 'nodeListPrototype');
        $attribute->setAccessible(true);
        $attribute->setValue($this->object, $prototype);

        $this->assertSame($prototype, $this->object->getNodeListPrototype());
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::cloneNodeListPrototype
     */
    public function testCloneNodeListPrototype()
    {
        $domNodes = $this->getMock('DOMNodeList');

        $prototype = $this->getMock('WebinoDraw\Dom\NodeList');
        $this->object->setNodeListPrototype($prototype);

        $prototype->expects($this->once())
            ->method('setNodes')
            ->with($this->equalTo($domNodes));

        $result = $this->object->cloneNodeListPrototype($domNodes);

        $this->assertEquals($prototype, $result);

        $this->assertNotSame($prototype, $result);
    }

    /**
     * Tests that instructions are placed into the stack with the right index
     *
     * Basically tests the instructions structure
     * after using the merge method.
     *
     * @covers WebinoDraw\Stdlib\DrawInstructions::merge
     */
    public function testMerge()
    {
        $instructions = array(
            'instruction_node1' => array('option' => 'value1'),
            'instruction_node2' => array('option' => 'value2'),
        );
        $expectOne = array(
            'instruction_node1' => $instructions['instruction_node1']
        );
        $expectTwo = array(
            'instruction_node2' => $instructions['instruction_node2']
        );

        $this->object->merge($instructions);

        $_instructions = $this->object->getArrayCopy();

        $this->assertEquals(
            array($expectOne, $expectTwo),
            array(
                $_instructions[DrawInstructions::STACK_SPACER],
                $_instructions[DrawInstructions::STACK_SPACER * 2]
            )
        );

        $this->object->merge($expectOne);
        $_instructionsOne = $this->object->getArrayCopy();

        $this->assertEquals(
            $expectOne, $_instructionsOne[DrawInstructions::STACK_SPACER]
        );

        $this->object->merge($expectTwo);
        $_instructionsTwo = $this->object->getArrayCopy();

        $this->assertEquals(
            $expectTwo, $_instructionsTwo[DrawInstructions::STACK_SPACER * 2]
        );
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::render
     */
    public function testRender()
    {
        $dom      = new \DOMDocument;
        $dom->loadXML('<root/>');
        $renderer = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $vars     = array('test_var' => 'test_val');

        $xpath  = $this->getMock('DOMXpath', array(), array(), '', false);
        $dom->documentElement->ownerDocument->xpath = $xpath;
        $plugin = $this->getMock('WebinoDraw\View\Helper\DrawElement');

        $spec = array(
            'locator' => 'body',
            'helper'  => 'drawElement',
        );

        $instructions = array(
            'test-node' => $spec,
        );

        $this->object->merge($instructions);

        $xpath
            ->expects($this->once())
            ->method('query')
            ->will($this->returnValue($dom->childNodes));

        $renderer
            ->expects($this->once())
            ->method('plugin')
            ->will($this->returnValue($plugin));

        $plugin
            ->expects($this->once())
            ->method('setVars')
            ->with($this->equalTo($vars))
            ->will($this->returnValue($plugin));

        $plugin
            ->expects($this->once())
            ->method('drawNodes')
            ->with($this->anything(), $this->equalTo($spec));

        $this->object->render($dom->documentElement, $renderer, $vars);
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::render
     */
    public function testRenderDisabledByEmptyNodes()
    {
        $dom      = new \DOMDocument;
        $dom->loadXML('<root/>');
        $renderer = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $vars     = array();

        $xpath  = $this->getMock('DOMXpath', array(), array(), '', false);
        $dom->documentElement->ownerDocument->xpath = $xpath;
        $plugin = $this->getMock('WebinoDraw\View\Helper\DrawElement');

        $spec = array(
            'locator' => 'body',
            'helper'  => 'drawElement',
        );

        $instructions = array(
            'test-node' => $spec,
        );

        $this->object->merge($instructions);

        $xpath
            ->expects($this->once())
            ->method('query')
            ->with($this->anything(), $this->equalTo($dom->documentElement))
            ->will($this->returnValue(new \DOMNodeList));

        $renderer
            ->expects($this->never())
            ->method('plugin');

        $this->object->render($dom->documentElement, $renderer, $vars);
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::render
     */
    public function testRenderDisabledByEmptyLocator()
    {
        $dom      = new \DOMDocument;
        $dom->loadXML('<root/>');
        $renderer = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $vars     = array();

        $xpath  = $this->getMock('DOMXpath', array(), array(), '', false);
        $dom->documentElement->ownerDocument->xpath = $xpath;

        $instructions = array(
            'test-node' => array(),
        );

        $this->object->merge($instructions);

        $xpath
            ->expects($this->never())
            ->method('query');

        $renderer
            ->expects($this->never())
            ->method('plugin');

        $this->object->render($dom->documentElement, $renderer, $vars);
    }

    /**
     * @covers WebinoDraw\Stdlib\DrawInstructions::render
     */
    public function testRenderCycle()
    {
        $dom      = new \DOMDocument;
        $dom->loadXML('<root/>');
        $renderer = $this->getMock('Zend\View\Renderer\PhpRenderer');
        $vars     = array('test_var' => 'test_val');

        $xpath  = $this->getMock('DOMXpath', array(), array(), '', false);
        $dom->documentElement->ownerDocument->xpath = $xpath;
        $plugin = $this->getMock('WebinoDraw\View\Helper\DrawElement');

        $spec = array(
            'locator' => 'body',
            'helper'  => 'drawElement',
        );

        $spec1 = array(
            'locator' => 'head',
            'helper'  => 'drawElement',
        );

        $spec2 = array(
            'locator' => 'footer',
            'helper'  => 'drawElement',
        );

        $instructions = array(
            'test-node1' => $spec1,
            'test-node2' => $spec2,
            'test-node'  => $spec,
        );

        $this->object->merge($instructions);

        $xpath
            ->expects($this->exactly(3))
            ->method('query')
            ->will($this->returnValue($dom->childNodes));

        $renderer
            ->expects($this->exactly(3))
            ->method('plugin')
            ->will($this->returnValue($plugin));

        $plugin
            ->expects($this->exactly(3))
            ->method('setVars')
            ->with($this->equalTo($vars))
            ->will($this->returnValue($plugin));

        $plugin
            ->expects($this->exactly(3))
            ->method('drawNodes')
            ->with(
                $this->anything(),
                $this->logicalOr(
                    $this->equalTo($spec),
                    $this->equalTo($spec1),
                    $this->equalTo($spec2)
                )
            );

        $this->object->render($dom->documentElement, $renderer, $vars);
    }
}
