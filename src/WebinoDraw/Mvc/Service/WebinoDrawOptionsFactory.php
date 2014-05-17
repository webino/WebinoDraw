<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Mvc\Service;

use WebinoDraw\WebinoDrawOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class WebinoDrawOptionsFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $services
     * @return WebinoDraw
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config')['webino_draw'];
        $instructionsFactory    = $services->get('WebinoDrawInstructionsFactory');
        $config['instructions'] = $instructionsFactory->create($config['instructions']);

        return new WebinoDrawOptions($config);
    }
}
