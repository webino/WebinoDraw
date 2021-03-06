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

use WebinoDraw\VarTranslator\Operation\Filter;
use WebinoDraw\VarTranslator\Operation\Helper;
use WebinoDraw\VarTranslator\Operation\OnVar;
use WebinoDraw\VarTranslator\VarTranslator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class VarTranslatorFactory
 */
class VarTranslatorFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return VarTranslator
     */
    public function createService(ServiceLocatorInterface $services)
    {
        /** @var \Zend\Filter\FilterPluginManager $filters */
        $filters = $services->get('FilterManager');
        /** @var \Zend\View\HelperPluginManager $helpers */
        $helpers = $services->get('ViewHelperManager');
        /** @var OnVar $onVar */
        $onVar = $services->get(OnVar::class);

        return new VarTranslator(new Filter($filters), new Helper($helpers), $onVar);
    }
}
