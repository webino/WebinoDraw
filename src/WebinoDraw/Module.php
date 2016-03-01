<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Service\Debugger;
use WebinoDraw\Debugger\Bar\DrawPanel;
use WebinoDraw\Draw\HelperPluginManager;
use WebinoDraw\Draw\LoopHelperPluginManager;
use WebinoDraw\Exception;
use WebinoDraw\Factory\HelperPluginManagerFactory;
use WebinoDraw\Factory\LoopHelperPluginManagerFactory;
use WebinoDraw\ModuleManager\Feature\WebinoDrawHelperProviderInterface;
use WebinoDraw\ModuleManager\Feature\WebinoDrawLoopHelperProviderInterface;
use Zend\Filter\FilterPluginManager;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * Class Module
 */
class Module implements ConfigProviderInterface
{
    /**
     * @param ModuleManagerInterface $manager
     */
    public function init(ModuleManagerInterface $manager)
    {
        if (!($manager instanceof ModuleManager)) {
            throw new Exception\LogicException('Expected ' . ModuleManager::class);
        }
        
        $services = $manager->getEvent()->getParam('ServiceManager');

        // Register draw helper manager
        $services->setFactory(
            'WebinoDrawHelperManager',
            HelperPluginManagerFactory::class
        );
        $services->get('ServiceListener')->addServiceManager(
            'WebinoDrawHelperManager',
            'webino_draw_helpers',
            WebinoDrawHelperProviderInterface::class,
            'getWebinoDrawHelperConfig'
        );

        // Register draw loop helper manager
        $services->setFactory(
            'WebinoDrawLoopHelperManager',
            LoopHelperPluginManagerFactory::class
        );
        $services->get('ServiceListener')->addServiceManager(
            'WebinoDrawLoopHelperManager',
            'webino_draw_loop_helpers',
            WebinoDrawLoopHelperProviderInterface::class,
            'getWebinoDrawLoopHelperConfig'
        );

        // Register a debugger bar panel
        if (class_exists(DebuggerFactory::class)) {
            $debugger = $services->get(DebuggerFactory::SERVICE);
            $debugger instanceof Debugger and $debugger->setBarPanel(new DrawPanel($manager), DrawPanel::ID);
        }

        // Fixing some DI issues but deprecated
        $manager->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST,
            function () use ($services) {

                // TODO: ZF2 issue
                // @link https://github.com/zendframework/zf2/issues/4573
                $services->get('FilterManager')->addPeeringServiceManager($services);
                $services->get('ViewHelperManager')->addPeeringServiceManager($services);
                $services->get('ValidatorManager')->addPeeringServiceManager($services);

                $instances = $services->get('Di')->instanceManager();

                // TODO: ZF2 DI issue
                // @link https://github.com/zendframework/zf2/issues/6290
                $instances->addSharedInstance(
                    $services->get('ViewHelperManager'),
                    HelperPluginManager::class
                );
                $instances->addSharedInstance(
                    $services->get('FilterManager'),
                    FilterPluginManager::class
                );
                $instances->addSharedInstance(
                    $services->get('WebinoDrawHelperManager'),
                    HelperPluginManager::class
                );
                $instances->addSharedInstance(
                    $services->get('WebinoDrawLoopHelperManager'),
                    LoopHelperPluginManager::class
                );
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
}
