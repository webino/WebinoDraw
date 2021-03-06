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

use WebinoDraw\Listener\AjaxFragmentListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AjaxFragmentListenerFactory
 */
class AjaxFragmentListenerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return AjaxFragmentListener
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return new AjaxFragmentListener($services->get('Request'));
    }
}
