<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory;

use WebinoDraw\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config     = $services->get('Config');
        $drawConfig = isset($config['webino_draw']) ? $config['webino_draw'] : [];

        if (array_key_exists('instructions', $drawConfig)) {
            $instructionsFactory        = $services->get('WebinoDraw\Factory\InstructionsFactory');
            $drawConfig['instructions'] = $instructionsFactory->create($drawConfig['instructions']);
        }

        return new ModuleOptions($drawConfig);
    }
}
