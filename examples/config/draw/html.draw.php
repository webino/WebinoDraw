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
    'set-html-extra-example' => [
        'locator' => 'h1',
        'html'    => '{$value}',

        'var' => [
            'set' => [
                'value' => 'Welcome to %sWebino%s',
            ],
            'helper' => [
                'value' => [
                    'sprintf' => [
                        '{$value}',
                        '<span class="zf-green">',
                        '</span>',
                    ],
                ],
            ],
        ],
    ],
    'html-on-empty-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '<div class="html-on-empty-example">NOT EMPTY HTML ON EMPTY</div>{$_innerHtml}',
    ],
    'html-on-empty-example' => [
        'locator' => '.html-on-empty-example',
        'html'    => '',

        'onEmpty' => [
            'locator' => 'xpath=.',
            'html'    => '<p>HTML ON EMPTY</p>',
        ],
    ],
];
