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

use WebinoDraw\Draw\Helper\CustomDiHelper;
use WebinoDraw\Draw\Helper\CustomHelper;
use WebinoDraw\Factory\ProfilingInstructionsRendererFactory;
use WebinoDraw\Instructions\InstructionsRenderer;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\I18n\Translator\TranslatorServiceFactory;

/**
 * Tests config
 */
return [
    'di' => [
        'instance' => [
            'alias' => [
                'CustomDiHelper' => CustomDiHelper::class,
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            TranslatorInterface::class  => TranslatorServiceFactory::class,
            InstructionsRenderer::class => ProfilingInstructionsRendererFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'example-form-route' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/example/form/route',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'save',
                    ],
                ],
            ],
            'heavy-test-route' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/heavy',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'heavy',
                    ],
                ],
            ],
            'xml-test-route' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/xml',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'xml',
                    ],
                ],
            ],
        ],
    ],
    'webino_draw' => [
        'instructions' => [
            'heavy-test-link' => [
                'locator' => '.nav li[1]',
                'html'    => '{$_innerHtml}<li><a href="{$href}">HEAVY TEST</a></li>',

                'var' => [
                    'set' => ['href' => ''],
                    'helper' => [
                        'href' => [
                            'url' => ['__invoke' => [['heavy-test-route']]],
                        ],
                    ],
                ],
            ],
            'xml-test-link' => [
                'locator' => '.nav li[1]',
                'html'    => '{$_innerHtml}<li><a href="{$href}">XML TEST</a></li>',

                'var' => [
                    'set' => ['href' => ''],
                    'helper' => [
                        'href' => [
                            'url' => ['__invoke' => [['xml-test-route']]],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'webino_draw_helpers' => [
        'invokables' => [
            'CustomHelper' => CustomHelper::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'application/index/heavy' => __DIR__ . '/../view/application/index/heavy.html',
            'application/index/xml'   => __DIR__ . '/../view/application/index/xml.xml',
        ],
    ],
    'translator' => [
        'translation_files' => [
            'sk/Zend_Validate' => [
                'type'   => 'phparray',
                'locale' => 'sk_SK',

                'filename' => current(
                    glob(__DIR__ . '/../../../vendor/zendframework/zend-i18n-resources/languages/sk/Zend_Validate.php')
                ),
            ],
        ],
    ],
];
