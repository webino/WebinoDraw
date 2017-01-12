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
    'remove-single-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="remove-me-single">THIS SHOULD BE REMOVED SINGLE</p>',
    ],
    'remove-single-example' => [
        'locator' => '.remove-me-single',
        'remove'  => 'xpath=.',
    ],
    'remove-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="remove-me">THIS SHOULD BE REMOVED</p><p class="remove-me-xpath">THIS SHOULD BE REMOVED BY XPATH</p>',
    ],
    'remove-example' => [
        'locator' => 'body',
        'remove' => [
            '.remove-me',
            'xpath=//*[@class="remove-me-xpath"]',
        ],
    ],
];
