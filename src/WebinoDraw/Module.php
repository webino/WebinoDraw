<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw;

use WebinoDraw\View\Helper\DrawElement;
use WebinoDraw\View\Helper\DrawForm;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\View\HelperPluginManager;

/**
 *
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ViewHelperProviderInterface
{
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
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(

                'WebinoDrawElement' => function(HelperPluginManager $pluginManager) {

                    $helper = new DrawElement;
                    $cache  = $pluginManager->getServiceLocator()->get('WebinoDrawCache');
                    $helper->setCache($cache);

                    return $helper;
                },

                'WebinoDrawForm' => function(HelperPluginManager $pluginManager) {

                    $helper = new DrawForm;
                    $cache  = $pluginManager->getServiceLocator()->get('WebinoDrawCache');
                    $helper->setCache($cache);

                    return $helper;
                },
            ),
        );
    }
}
