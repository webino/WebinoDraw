<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper\Factory;

use WebinoDraw\Draw\Helper\Form;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class FormFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $drawHelpers
     * @return Form
     */
    public function createService(ServiceLocatorInterface $drawHelpers)
    {
        $services    = $drawHelpers->getServiceLocator();
        $viewHelpers = $services->get('ViewHelperManager');

        return new Form(
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
