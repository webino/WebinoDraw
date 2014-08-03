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
                __DIR__ . '/../data/di/InstructionsRenderer.definition.php',
            ],
        ],
        'instance' => [
            'alias' => [
                'WebinoDraw'               => 'WebinoDraw\Service\DrawService',
                'WebinoDrawOptions'        => 'WebinoDraw\Options\ModuleOptions',
                'WebinoDrawCache'          => 'Zend\Cache\Storage\Adapter\Filesystem',
                'WebinoDrawTranslate'      => 'WebinoDraw\Draw\Helper\Translate',
                'WebinoDrawPagination'     => 'WebinoDraw\Draw\Helper\Pagination',
                'WebinoDrawFormCollection' => 'Zend\Form\View\Helper\FormCollection',
                'WebinoDrawFormRow'        => 'WebinoDraw\Form\View\Helper\FormRow',
                'WebinoDrawFormElement'    => 'WebinoDraw\Form\View\Helper\FormElement',
            ],
            'WebinoDraw' => [
                'parameters' => [
                    'options' => 'WebinoDrawOptions',
                ],
            ],
            'WebinoDraw\Instructions\InstructionsRenderer' => [
                'parameters' => [
                    'drawOptions' => 'WebinoDrawOptions',
                ],
            ],
            'WebinoDrawVarTranslator' => [
                'parameters' => [
                    'helpers' => 'ViewHelperManager',
                    'filters' => 'FilterManager',
                ],
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
            'WebinoDrawFormCollection' => [
                'injections' => [
                    'setDefaultElementHelper' => [
                        'defaultSubHelper' => 'webinodrawformrow',
                    ],
                ],
            ],
            'WebinoDrawFormRow' => [
                'injections' => [
                    'setElementHelper' => [
                        'elementHelper' => 'WebinoDrawFormElement',
                    ],
                ],
            ],
            'WebinoDrawFormElement' => [
                'injections' => [
                    'View',
                ],
            ],
            'WebinoDraw\Form\DiForm' => [
                'parameters' => [
                    'formFactory' => 'FormFactory',
                ],
            ],
            'WebinoDraw\Manipulator\Plugin\Value' => [
                'parameters' => [
                    'escapeHtml' => 'Zend\View\Helper\EscapeHtml',
                ],
            ],
            'WebinoDraw\Manipulator\Manipulator' => [
                'injections' => [
                    'setPlugin' => [
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Loop',
                            'priority' => 500,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Render',
                            'priority' => 110,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Fragments',
                            'priority' => 100,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\NodeTranslation',
                            'priority' => 90,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\VarTranslation',
                            'priority' => 80,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Remove',
                            'priority' => 70,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Replace',
                            'priority' => 60,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Attribs',
                            'priority' => 50,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Value',
                            'priority' => 40,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Html',
                            'priority' => 30,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\Cdata',
                            'priority' => 20,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\OnVar',
                            'priority' => 10,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\OnEmpty',
                            'priority' => -100,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\Manipulator\Plugin\SubInstructions',
                            'priority' => -500,
                        ],
                    ],
                ],
            ],
            'WebinoDraw\VarTranslator\Operation\OnVar' => [
                'injections' => [
                    'setPlugin' => [
                        [
                            'plugin'   => 'WebinoDraw\VarTranslator\Operation\OnVar\EqualTo',
                            'priority' => 100,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\VarTranslator\Operation\OnVar\NotEqualTo',
                            'priority' => 90,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\VarTranslator\Operation\OnVar\GreaterThan',
                            'priority' => 80,
                        ],
                        [
                            'plugin'   => 'WebinoDraw\VarTranslator\Operation\OnVar\LessThan',
                            'priority' => 70,
                        ],
                    ],
                ],
            ],
            'WebinoDraw\View\Renderer\DrawRenderer' => [
                'parameters' => [
                    'draw' => 'WebinoDraw',
                ],
            ],
            'WebinoDraw\Listener\AjaxFragmentListener' => [
                'parameters' => [
                    'request' => 'Request',
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
            'WebinoDrawOptions'  => 'WebinoDraw\Factory\ModuleOptionsFactory',
            'WebinoDrawStrategy' => 'WebinoDraw\Factory\DrawStrategyFactory',
        ],
    ],
    'view_manager' => [
        'doctype'    => 'XHTML5', // !!!XML REQUIRED
        'strategies' => ['WebinoDrawStrategy'],

        'template_map' => [
            'webino-draw/snippet/pagination' => __DIR__ . '/../view/webino-draw/snippet/pagination.html',
        ],
    ],
];
