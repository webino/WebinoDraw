<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory\HelperFactory;

use WebinoDraw\Draw\Helper\Absolutize;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbsolutizeFactory
 */
class AbsolutizeFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $drawHelpers
     * @return Absolutize
     */
    public function createService(ServiceLocatorInterface $drawHelpers)
    {
        $viewHelpers = $drawHelpers->getServiceLocator()->get('ViewHelperManager');
        return new Absolutize($viewHelpers->get('ServerUrl'), $viewHelpers->get('BasePath'));
    }
}
