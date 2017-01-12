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
    'locator-var-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '<div class="locator-var-example">LOCATOR VAR EXAMPLE</div>{$_innerHtml}',
    ],
    'locator-var-example' => [
        'locator' => 'xpath=.',
        'var' => [
            'set' => [
                'locator' => 'locator-var',
            ],
        ],
        'instructions' => [
            'locator-var-example' => [
                'locator' => '.{$locator}-example',
                'value'   => '{$_nodeValue} OK',
            ],
        ],
    ],
];
