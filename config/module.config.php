<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use WebinoDraw\Cache\DrawCache;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Factory;
use WebinoDraw\Factory\InstructionsFactory;
use WebinoDraw\Form\View\Helper\FormElement;
use WebinoDraw\Form\View\Helper\FormRow;
use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Listener\AjaxFragmentListener;
use WebinoDraw\Manipulator\Manipulator;
use WebinoDraw\Options\ModuleOptions;
use WebinoDraw\Service\DrawProfiler;
use WebinoDraw\Service\DrawService;
use WebinoDraw\VarTranslator\Operation\OnVar;
use WebinoDraw\VarTranslator\VarTranslator;
use WebinoDraw\View\Renderer\DrawRenderer;
use WebinoDraw\View\Strategy\DrawStrategy;

/**
 * Do not write your custom settings into this file
 */
return [
    'di' => [
        'definition' => [
            'compiler' => [
                __DIR__ . '/../data/di/definition.php',
            ],
        ],
        'instance' => [
            'alias' => [
                DrawService::SERVICE => DrawService::class,
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            InstructionsFactory::class => InstructionsFactory::class,
        ],
        'factories' => [
            AjaxFragmentListener::class => Factory\AjaxFragmentListenerFactory::class,
            DrawCache::class            => Factory\DrawCacheFactory::class,
            DrawCache::STORAGE          => Factory\DrawCacheStorageFactory::class,
            DrawProfiler::class         => Factory\DrawProfilerFactory::class,
            DrawRenderer::class         => Factory\DrawRendererFactory::class,
            DrawService::SERVICE        => Factory\DrawServiceFactory::class,
            DrawStrategy::SERVICE       => Factory\DrawStrategyFactory::class,
            InstructionsRenderer::class => Factory\InstructionsRendererFactory::class,
            Locator::class              => Factory\DomLocatorFactory::class,
            Manipulator::class          => Factory\ManipulatorFactory::class,
            ModuleOptions::SERVICE      => Factory\ModuleOptionsFactory::class,
            OnVar::class                => Factory\OnVarOperationFactory::class,
            VarTranslator::class        => Factory\VarTranslatorFactory::class,
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            FormRow::SERVICE     => FormRow::class,
            FormElement::SERVICE => FormElement::class,
        ],
    ],
    'view_manager' => [
        'doctype'    => 'XHTML5', // !!!XML REQUIRED
        'strategies' => [DrawStrategy::SERVICE],

        'template_map' => [
            'webino-draw/snippet/pagination' => __DIR__ . '/../view/webino-draw/snippet/pagination.html',
        ],
    ],
];
