<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

/**
 * Test config
 */
return [
    'service_manager' => [
        'factories' => [
            'Zend\I18n\Translator\TranslatorInterface' => 'Zend\I18n\Translator\TranslatorServiceFactory',
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
        ],
    ],
    'webino_draw' => [
        'instructions' => [
            'heavy-test-link' => [
                'locator' => '.nav li[1]',
                'html'    => '{$_innerHtml}<li><a href="{$href}">HEAVY TEST</a></li>',

                'var' => [
                    'set' => [
                        'href' => '',
                    ],
                    'helper' => [
                        'href' => [
                            'url' => [
                                '__invoke' => [['heavy-test-route']],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'application/index/heavy' => __DIR__ . '/../view/application/index/heavy.html',
        ],
    ],
    'translator' => [
        'translation_files' => [
            [
                'type'   => 'phparray',
                'locale' => 'sk_SK',

                'filename' => current(
                    glob(__DIR__ . '/../../../vendor/*/zendframework/resources/languages/sk/Zend_Validate.php')
                ),
            ],
        ],
    ],
    'zenddevelopertools' => [
        'profiler' => [
            'enabled'     => true,
            'strict'      => false,
            'flush_early' => false,
            'cache_dir'   => 'data/cache',
            'matcher'     => [],
            'collectors'  => ['db' => null],
        ],
        'toolbar' => [
            'enabled'       => true,
            'auto_hide'     => false,
            'position'      => 'bottom',
            'version_check' => true,
            'entries'       => [],
        ],
    ],
];
