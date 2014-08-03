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

return [
    'subInstructions-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="subinstructions-example"><span>SUB-INSTRUCTIONS</span> <strong>EXAMPLE</strong> <form/></div>',
    ],
    'subInstructions-example' => [
        'locator' => '.subinstructions-example',
        'instructions' => [
            'subtest1' => [
                'stackIndex' => '99',
                'locator'    => 'span',
                'value'      => '{$_nodeValue}(TEST)',
            ],
            'subtest2' => [
                'locator' => 'xpath=.//strong',
                'value'   => '{$_nodeValue} VALUE',
            ],
            'subtest-form' => [
                'locator'     => 'form',
                'helper'      => 'WebinoDrawForm',
                'form'        => 'exampleForm',
                'route'       => 'example-form-route',
                'text_domain' => 'test',

                'instructions' => [
                    'form-decorator1' => [
                        'locator' => 'label span',
                        'value'   => '{$_nodeValue}*',
                    ],
                ],
            ],
        ],
    ],
];
