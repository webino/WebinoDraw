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

use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Options\ModuleOptions;
use WebinoDraw\Service\DrawService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawServiceFactory
 */
class DrawServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return DrawService
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return new DrawService(
            $services->get(ModuleOptions::SERVICE),
            $services->get(InstructionsRenderer::class)
        );
    }
}
