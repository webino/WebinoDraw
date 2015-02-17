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
    'di' => [
        'instance' => [
            'alias' => [
                'CustomDiHelper' => 'WebinoDraw\Draw\Helper\CustomDiHelper',
            ],
        ],
    ],
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
            'CustomHelper' => 'WebinoDraw\Draw\Helper\CustomHelper',
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
            'auto_hide'     => true,
            'position'      => 'top',
            'version_check' => true,
            'entries'       => [],
        ],
    ],
];
