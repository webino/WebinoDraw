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

use WebinoDraw\Cache\DrawCache;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawCacheFactory
 */
class DrawCacheFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return DrawCache
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return new DrawCache($services->get(DrawCache::STORAGE));
    }
}
