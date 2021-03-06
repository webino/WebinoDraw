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

use Zend\Cache\StorageFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawCacheStorageFactory
 */
class DrawCacheStorageFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return \Zend\Cache\Storage\StorageInterface
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return StorageFactory::factory([
            'adapter' => [
                'name' => 'filesystem',
                'options' => [
                    'namespace'      => 'webinodraw',
                    'cacheDir'       => 'data/cache',
                    'dirPermission'  => false,
                    'filePermission' => false,
                    'umask'          => 7,
                ],
            ],
        ]);
    }
}
