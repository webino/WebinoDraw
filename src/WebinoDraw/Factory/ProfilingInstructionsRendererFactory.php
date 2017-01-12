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

use WebinoDraw\Dom\Locator;
use WebinoDraw\Instructions\ProfilingInstructionsRenderer;
use WebinoDraw\Service\DrawProfiler;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ProfilingInstructionsRendererFactory
 */
class ProfilingInstructionsRendererFactory extends AbstractInstructionsRendererFactory
{
    /**
     * Profiling instructions renderer class
     */
    const ENGINE_CLASS = ProfilingInstructionsRenderer::class;

    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $services)
    {
        /** @var ProfilingInstructionsRenderer $service */
        $service = parent::createService($services);
        $service->setProfiler($services->get(DrawProfiler::class));
        return $service;
    }
}
