<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory;

use WebinoDraw\Service\DrawService;
use WebinoDraw\View\Renderer\DrawRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawRendererFactory
 */
class DrawRendererFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return DrawRenderer
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return new DrawRenderer(
            $services->get(DrawService::SERVICE),
            $services->get('ViewRenderer')
        );
    }
}
