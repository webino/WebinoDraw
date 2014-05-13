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
];
