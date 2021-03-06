<?php

namespace WebinoDraw\Factory;

use WebinoDraw\Factory\InstructionsFactory;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-10-13 at 20:36:22.
 */
class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptionsFactory
     */
    protected $object;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $services;

    /**
     * @var InstructionsFactory
     */
    protected $instructionsFactory;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object   = new ModuleOptionsFactory;
        $this->services = $this->getMock('Zend\ServiceManager\ServiceManager');
        $this->instructionsFactory = new InstructionsFactory;

        $this->services->expects($this->any())
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($name) {

                        switch ($name) {
                            case 'Config':
                                return $this->config;

                            case 'WebinoDraw\Factory\InstructionsFactory':
                                return $this->instructionsFactory;
                        }

                        $this->fail(sprintf('Unexpected service %s', $name));
                    }
                )
            );
    }

    /**
     * @covers WebinoDraw\Factory\ModuleOptionsFactory::createService
     */
    public function testCreateServiceEmptyConfig()
    {
        $this->config = [];
        $this->object->createService($this->services);
    }

    /**
     * @covers WebinoDraw\Factory\ModuleOptionsFactory::createService
     */
    public function testCreateServiceEmptyInstructions()
    {
        $this->config = ['webino_draw' => ['instructions' => []]];
        $this->object->createService($this->services);
    }
}
