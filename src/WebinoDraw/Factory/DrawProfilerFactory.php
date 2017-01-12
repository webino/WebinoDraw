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

use WebinoDebug\Factory\DebuggerFactory;
use WebinoDraw\Service\DrawProfiler;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawProfilerFactory
 */
class DrawProfilerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return DrawProfiler
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return new DrawProfiler($services->get(DebuggerFactory::SERVICE));
    }
}
