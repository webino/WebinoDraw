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
 * Do not write your custom settings into this file
 */
return [
    'di' => [
        'definition' => [
            'compiler' => [
                __DIR__ . '/../data/di/definition.php',
                __DIR__ . '/../data/di/DiForm.definition.php',
            ],
            'class' => [
                'WebinoDraw\View\Helper\DrawForm' => [
                    'methods' => [
                        'setTranslatorTextDomain' => [
                            'textDomain' => ['default' => null],
                        ],
                        'setRenderErrors' => [
                            'bool' => ['default' => null],
                        ],
                    ],
                ],
            ],
        ],
        'instance' => [
            'alias' => [
                'WebinoDraw'           => 'WebinoDraw\WebinoDraw',
                'WebinoDrawCache'      => 'Zend\Cache\Storage\Adapter\Filesystem',
                'WebinoDrawElement'    => 'WebinoDraw\View\Helper\DrawElement',
                'WebinoDrawForm'       => 'WebinoDraw\View\Helper\DrawForm',
                'WebinoDrawPagination' => 'WebinoDraw\View\Helper\DrawPagination',
                'WebinoDrawTranslate'  => 'WebinoDraw\View\Helper\DrawTranslate',
            ],
            'WebinoDrawCache' => [
                'parameters' => [
                    'options' => [
                        'namespace'      => 'webinodraw',
                        'cacheDir'       => 'data/cache',
                        'dirPermission'  => false,
                        'filePermission' => false,
                        'umask'          => 7,
                    ],
                ],
            ],
            'WebinoDrawElement' => [
                'injections' => [
                    'FilterManager',
                    'WebinoDrawCache',
                ],
            ],
            'WebinoDrawForm' => [
                'injections' => [
                    'FilterManager',
                    'WebinoDrawCache',
                ],
            ],
            'WebinoDrawPagination' => [
                'injections' => [
                    'FilterManager',
                    'WebinoDrawCache',
                ],
            ],
            'WebinoDrawTranslate' => [
                'injections' => [
                    'FilterManager',
                    'WebinoDrawCache',
                ],
            ],
            'WebinoDraw\Form\DiForm' => [
                'parameters' => [
                    'formFactory' => 'FormFactory',
                ],
            ],
            'WebinoDraw\Listener\AjaxFragmentListener' => [
                'parameters' => [
                    'request' => 'Request',
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'WebinoDraw'         => 'WebinoDraw\Mvc\Service\WebinoDrawFactory',
            'WebinoDrawStrategy' => 'WebinoDraw\Mvc\Service\DrawStrategyFactory',
        ],
    ],
    'view_helpers' => [
        'factories'  => [
            'WebinoDrawElement'    => 'WebinoDraw\Mvc\Service\ServiceViewHelperFactory',
            'WebinoDrawForm'       => 'WebinoDraw\Mvc\Service\ServiceViewHelperFactory',
            'WebinoDrawPagination' => 'WebinoDraw\Mvc\Service\ServiceViewHelperFactory',
            'WebinoDrawTranslate'  => 'WebinoDraw\Mvc\Service\ServiceViewHelperFactory',
        ],
        'invokables' => [
            'WebinoDrawAbsolutize'     => 'WebinoDraw\View\Helper\DrawAbsolutize',
            'WebinoDrawFormRow'        => 'WebinoDraw\Form\View\Helper\FormRow',
            'WebinoDrawFormElement'    => 'WebinoDraw\Form\View\Helper\FormElement',
            'WebinoDrawFormCollection' => 'Zend\Form\View\Helper\FormCollection',
        ],
    ],
    'view_manager' => [
        'doctype'      => 'XHTML5', // !!!XML REQUIRED
        'strategies'   => ['WebinoDrawStrategy'],
        'template_map' => [
            'webino-draw/snippet/pagination' => __DIR__ . '/../view/webino-draw/snippet/pagination.html',
        ],
    ],
];
