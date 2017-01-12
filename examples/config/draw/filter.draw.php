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
    'filter-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="filter-example">-this should be upper case-</p>',
    ],
    'filter-example' => [
        'locator' => '.filter-example',
        'value'   => '{$_nodeValue}',

        'var' => [
            'filter' => [
                'pre' => [
                    '_nodeValue' => [
                        'stringToUpper' => ['{$_nodeValue}'],
                        'trim'          => ['{$_nodeValue}', '-'],
                    ],
                ],
            ],
        ],
    ],
];
