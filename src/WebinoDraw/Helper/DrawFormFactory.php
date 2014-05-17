<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class DrawFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $drawHelpers)
    {
        $services    = $drawHelpers->getServiceLocator();
        $viewHelpers = $services->get('ViewHelperManager');

        return new DrawForm(
            $services,
            $viewHelpers->get('WebinoDrawFormRow'),
            $viewHelpers->get('WebinoDrawFormElement'),
            $viewHelpers->get('FormElementErrors'),
            $viewHelpers->get('WebinoDrawFormCollection'),
            $viewHelpers->get('Url'),
            $services->get('WebinoDraw\Instructions\InstructionsRenderer')
        );
    }
}
