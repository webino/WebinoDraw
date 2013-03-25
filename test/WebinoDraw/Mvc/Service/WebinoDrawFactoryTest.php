<?php

namespace WebinoDraw\Mvc\Service;

/**
 * Test class for WebinoDrawFactory.
 * Generated by PHPUnit on 2013-03-19 at 21:36:14.
 */
class WebinoDrawFactoryTest
        extends \PHPUnit_Framework_TestCase
{

    /**
     * @var WebinoDrawFactory
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new WebinoDrawFactory;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\Mvc\Service\WebinoDrawFactory::createService
     */
    public function testCreateService()
    {
        $services = $this->getMock('Zend\ServiceManager\ServiceManager');
        $testCase = $this;
        $config   = array('webino_draw' => array());
        $renderer = $this->getMock('Zend\View\Renderer\PhpRenderer');

        $services->expects($this->exactly(2))
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($name) use ($config, $renderer, $testCase) {

                        switch ($name) {
                            case 'Config':
                                return $config;
                                break;

                            case 'ViewRenderer':
                                return $renderer;
                                break;
                        }

                        $testCase->fail(sprintf('Unexpected service %s', $name));
                    }
                )
            );

        $this->assertThat(
            $this->object->createService($services),
            $this->isInstanceOf('WebinoDraw\WebinoDraw')
        );
    }
}
