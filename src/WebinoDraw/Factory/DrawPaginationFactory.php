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

use WebinoDraw\Draw\Helper\Pagination;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawPaginationFactory
 */
class DrawPaginationFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return Pagination
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return new Pagination($services->getServiceLocator());
    }
}
