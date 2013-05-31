<?php

namespace WebinoDraw\Mvc\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceViewHelperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator, $name = null, $requestedName = null)
    {
        if (!($serviceLocator instanceof \Zend\View\HelperPluginManager)) {
            throw new \InvalidArgumentException('Expected HelperPluginManager service locator');
        }

        return $serviceLocator->getServiceLocator()->get($requestedName);
    }
}
