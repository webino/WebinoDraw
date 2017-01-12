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

return [
    'on-var-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="on-var-equal-to-example"/>'
                     . '<div class="on-var-not-equal-to-example"/>',
    ],
    'on-var-example' => [
        'locator' => 'xpath=.',
        'var' => [
            'fetch' => [
                'depthvar' => 'value.in.the.depth',
            ],
        ],
        'onVar' => [
            'test-equal-to' => [
                'var'     => '{$depthvar}',
                'equalTo' => 'DEPTHVAR',

                'instructions' => [
                    'custom-name' => [
                        'locator' => '.on-var-equal-to-example',
                        'value'   => 'ON VAR VALUE EQUAL TO',
                    ],
                ],
            ],
            'test-not-equal-to' => [
                'var'        => '{$depthvar}',
                'notEqualTo' => '',

                'instructions' => [
                    'custom-name' => [
                        'locator' => '.on-var-not-equal-to-example',
                        'value'   => 'ON VAR VALUE NOT EQUAL TO',
                    ],
                ],
            ],
        ],
    ],
];
