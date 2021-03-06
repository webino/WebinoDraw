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

use WebinoDraw\VarTranslator\Operation\OnVar;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OnVarOperationFactory
 */
class OnVarOperationFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return OnVar
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return (new OnVar)
            ->setPlugin(new OnVar\EqualTo)
            ->setPlugin(new OnVar\NotEqualTo)
            ->setPlugin(new OnVar\LessThan)
            ->setPlugin(new OnVar\GreaterThan)
            ->setPlugin(new OnVar\IsNumeric);
    }
}
