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

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 *
 */
class Module implements ConfigProviderInterface
{
    /**
     * @param ModuleManagerInterface $manager
     */
    public function init(ModuleManagerInterface $manager)
    {
        $services = $manager->getEvent()->getParam('ServiceManager');

        // Register draw helper manager
        $services->setFactory(
            'WebinoDrawHelperManager',
            'WebinoDraw\Factory\HelperPluginManagerFactory'
        );
        $services->get('ServiceListener')->addServiceManager(
            'WebinoDrawHelperManager',
            'webino_draw_helpers',
            'WebinoDraw\ModuleManager\Feature\WebinoDrawHelperProviderInterface',
            'getWebinoDrawHelperConfig'
        );

        // Register draw loop helper manager
        $services->setFactory(
            'WebinoDrawLoopHelperManager',
            'WebinoDraw\Factory\LoopHelperPluginManagerFactory'
        );
        $services->get('ServiceListener')->addServiceManager(
            'WebinoDrawLoopHelperManager',
            'webino_draw_loop_helpers',
            'WebinoDraw\ModuleManager\Feature\WebinoDrawLoopHelperProviderInterface',
            'getWebinoDrawLoopHelperConfig'
        );

        //
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
                    'Zend\View\HelperPluginManager'
                );
                $instances->addSharedInstance(
                    $services->get('FilterManager'),
                    'Zend\Filter\FilterPluginManager'
                );
                $instances->addSharedInstance(
                    $services->get('WebinoDrawHelperManager'),
                    'WebinoDraw\Draw\HelperPluginManager'
                );
                $instances->addSharedInstance(
                    $services->get('WebinoDrawLoopHelperManager'),
                    'WebinoDraw\Draw\LoopHelperPluginManager'
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
