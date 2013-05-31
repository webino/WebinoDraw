<?php

namespace WebinoDraw\Mvc\Service;

/**
 * Test class for ServiceViewHelperFactory.
 * Generated by PHPUnit on 2013-05-31 at 23:01:10.
 */
class ServiceViewHelperFactoryTest
        extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ServiceViewHelperFactory
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ServiceViewHelperFactory;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers WebinoDraw\Mvc\Service\ServiceViewHelperFactory::createService
     */
    public function testCreateService()
    {
        $services = $this->getMock('Zend\ServiceManager\ServiceManager');
        $plugins = $this->getMock('Zend\View\HelperPluginManager', array(), array(), '', false);
        $viewHelper = $this->getMock('WebinoDraw\View\Helper\DrawElement');
        $requestedName = 'TestHelperName';

        $plugins->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($services));

        $services->expects($this->once())
            ->method('get')
            ->with($requestedName)
            ->will($this->returnValue($viewHelper));

        $result = $this->object->createService($plugins, null, $requestedName);

        $this->assertSame($viewHelper, $result);
    }

    /**
     * @covers WebinoDraw\Mvc\Service\ServiceViewHelperFactory::createService
     */
    public function testCreateServiceNotHelperPluginManager()
    {
        $this->setExpectedException('InvalidArgumentException');

        $services = $this->getMock('Zend\ServiceManager\ServiceManager');

        $this->object->createService($services);
    }
}
