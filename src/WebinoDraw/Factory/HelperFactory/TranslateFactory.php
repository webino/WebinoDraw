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

use WebinoDraw\Draw\Helper\Translate;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TranslateFactory
 */
class TranslateFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $drawHelpers
     * @return Translate
     */
    public function createService(ServiceLocatorInterface $drawHelpers)
    {
        /** @var \WebinoDraw\Draw\HelperPluginManager $drawHelpers */
        $services = $drawHelpers->getServiceLocator();
        return new Translate($services->get(TranslatorInterface::class));
    }
}
