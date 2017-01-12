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

use WebinoDraw\View\Strategy\DrawStrategy;
use WebinoDraw\View\Strategy\DrawAjaxHtmlStrategy;
use WebinoDraw\View\Strategy\DrawAjaxJsonStrategy;
use Zend\Http\Request as HttpRequest;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawStrategyFactory
 */
class DrawStrategyFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return \WebinoDraw\View\Strategy\AbstractDrawStrategy
     */
    public function createService(ServiceLocatorInterface $services)
    {
        /* @var $request HttpRequest */
        $request = $services->get('Request');
        /* @var $service \WebinoDraw\Service\DrawService */
        $service = $services->get('WebinoDraw');

        if (($request instanceof HttpRequest) && $request->isXmlHttpRequest()) {

            $acceptHeaders = $request->getHeader('accept')->getPrioritized();
            if ('application/json' === $acceptHeaders[0]->getRaw()) {
                return new DrawAjaxJsonStrategy($service);
            }

            return new DrawAjaxHtmlStrategy($service);
        }

        return new DrawStrategy($service);
    }
}
