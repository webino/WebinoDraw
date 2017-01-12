<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Mvc\Service;

use WebinoDraw\Mvc\View\Http\ViewManager;
use Zend\Mvc\Service\HttpViewManagerFactory as BaseHttpViewManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * 
 */
class HttpViewManagerFactory extends BaseHttpViewManagerFactory
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return new ViewManager;
    }
}
