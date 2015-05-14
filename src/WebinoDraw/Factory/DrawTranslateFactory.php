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

use WebinoDraw\Draw\Helper\Translate;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DrawTranslateFactory
 */
class DrawTranslateFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return Translate
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $superServices = $services->getServiceLocator();
        return new Translate($superServices->get(TranslatorInterface::class));
    }
}
