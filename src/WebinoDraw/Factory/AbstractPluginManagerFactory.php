<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory;

use Zend\Mvc\Exception;
use Zend\Mvc\Service\AbstractPluginManagerFactory as BaseAbstractPluginManagerFactory;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\HelperInterface as ViewHelperInterface;

/**
 * Class AbstractPluginManagerFactory
 */
abstract class AbstractPluginManagerFactory extends BaseAbstractPluginManagerFactory
{
    /**
     * An array of helper configuration classes to ensure are on the helper_map stack.
     *
     * @var array
     */
    protected $defaultHelperMapClasses = [];

    /**
     * Create and return the draw loop helper manager
     *
     * @param ServiceLocatorInterface $services
     * @return ViewHelperInterface
     * @throws Exception\RuntimeException
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $plugins = parent::createService($services);

        foreach ($this->defaultHelperMapClasses as $configClass) {
            if (!is_string($configClass) || !class_exists($configClass)) {
                continue;
            }
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

        /** @var \Zend\ServiceManager\ServiceManager $services */
        $plugins->addPeeringServiceManager($services);
        return $plugins;
    }
}
