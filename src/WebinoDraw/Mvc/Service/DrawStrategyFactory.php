<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Mvc\Service;

use WebinoDraw\View\Strategy\DrawAjaxStrategy;
use WebinoDraw\View\Strategy\DrawStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class DrawStrategyFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return AbstractDrawStrategy
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $service = $services->get('WebinoDraw');
        $isAjax  = $services->get('Request')->isXmlHttpRequest();

        if ($isAjax) {
            return new DrawAjaxStrategy($service);
        }

        return new DrawStrategy($service);
    }
}
