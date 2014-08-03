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
    'cache-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="cache-example"></div>',
    ],
    'cache-example' => [
        'locator' => '.cache-example',
        'value'   => 'CACHED? {$rand}',
        'cache'   => 'example',
        
        'var' => [
            'set' => [
                'rand' => '',
            ],
            'helper' => [
                'rand' => [
                    'rand' => [],
                ],
            ],
        ],
    ],
];
