<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Mvc\Service;

use Zend\Mvc\Exception;
use Zend\Mvc\Service\AbstractPluginManagerFactory;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\HelperInterface as ViewHelperInterface;

/**
 *
 */
class WebinoDrawHelperManagerFactory extends AbstractPluginManagerFactory
{
    // TODO
    const PLUGIN_MANAGER_CLASS = 'WebinoDraw\HelperPluginManager';

    /**
     * An array of helper configuration classes to ensure are on the helper_map stack.
     *
     * @var array
     */
    protected $defaultHelperMapClasses = [];

    /**
     * Create and return the view helper manager
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ViewHelperInterface
     * @throws Exception\RuntimeException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $plugins = parent::createService($serviceLocator);

        foreach ($this->defaultHelperMapClasses as $configClass) {
            if (is_string($configClass) && class_exists($configClass)) {
                $config = new $configClass;

                if (!$config instanceof ConfigInterface) {
                    throw new Exception\RuntimeException(sprintf(
                        'Invalid service manager configuration class provided; received "%s",'
                        . ' expected class implementing %s',
                        $configClass,
                        'Zend\ServiceManager\ConfigInterface'
                    ));
                }

                $config->configureServiceManager($plugins);
            }
        }

//        $serviceListener = $serviceLocator->get('ServiceListener');
//        $serviceListener->addServiceManager(
//            'WebinoDrawHelperManager',
//            'webino_draw_helpers',
//            'WebinoDraw\ModuleManager\Feature\WebinoDrawHelperProviderInterface',
//            'getWebinoDrawHelpers'
//        );

        return $plugins;
    }
}
