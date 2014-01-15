<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Mvc\Service;

use WebinoDraw\WebinoDraw;
use WebinoDraw\WebinoDrawOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class WebinoDrawFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $services
     * @return WebinoDraw
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');

        return new WebinoDraw(
            $services->get('ViewRenderer'),
            new WebinoDrawOptions($config['webino_draw'])
        );
    }
}
