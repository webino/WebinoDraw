<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 *
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface
{
    public function init(ModuleManagerInterface $manager)
    {
        $services = $manager->getEvent()->getParam('ServiceManager');

        // Register draw helper manager
        $services->setFactory(
            'WebinoDrawHelperManager',
            'WebinoDraw\Mvc\Service\WebinoDrawHelperManagerFactory'
        );
        $services->get('ServiceListener')->addServiceManager(
            'WebinoDrawHelperManager',
            'webino_draw_helpers',
            'WebinoDraw\ModuleManager\Feature\WebinoDrawHelperProviderInterface',
            'getWebinoDrawHelperConfig'
        );

        //
        $manager->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST,
            function (ModuleEvent $event) {
                $services  = $event->getParam('ServiceManager');
                $instances = $services->get('Di')->instanceManager();

                // todo ?
                $instances->addSharedInstance(
                    $services->get('ViewHelperManager'),
                    'Zend\View\HelperPluginManager'
                );
                $services->get('ViewHelperManager')->addPeeringServiceManager($services);

                // todo ?
                $instances->addSharedInstance(
                    $services->get('FilterManager'),
                    'Zend\Filter\FilterPluginManager'
                );
                $services->get('FilterManager')->addPeeringServiceManager($services);

                // todo ?
                $instances->addSharedInstance(
                    $services->get('WebinoDrawHelperManager'),
                    'WebinoDraw\HelperPluginManager'
                );
                $services->get('WebinoDrawHelperManager')->addPeeringServiceManager($services);
            }
        );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'WebinoDraw\View\Renderer\DrawRenderer' => function ($services) {
                    return new View\Renderer\DrawRenderer(
                        $services->get('WebinoDraw'),
                        $services->get('ViewRenderer')
                    );
                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [__NAMESPACE__ => __DIR__],
            ],
        ];
    }
}
