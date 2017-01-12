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

use WebinoDraw\Dom\Factory\NodeListFactory;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Factory\InstructionsFactory;
use WebinoDraw\Instructions\InstructionsRendererInterface;
use WebinoDraw\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractInstructionsRendererFactory
 */
abstract class AbstractInstructionsRendererFactory implements FactoryInterface
{
    /**
     * Instructions renderer class
     */
    const ENGINE_CLASS = InstructionsRendererInterface::class;

    /**
     * @param ServiceLocatorInterface $services
     * @return InstructionsRendererInterface
     */
    public function createService(ServiceLocatorInterface $services)
    {
        /** @var Locator $domLocator */
        $domLocator = $services->get(Locator::class);

        $rendererClass = $this::ENGINE_CLASS;
        return new $rendererClass(
            $services->get('WebinoDrawHelperManager'),
            $domLocator,
            new NodeListFactory($domLocator),
            new InstructionsFactory,
            $services->get(ModuleOptions::SERVICE)
        );
    }
}
