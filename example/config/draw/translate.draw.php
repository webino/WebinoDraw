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
    'translate-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="translate-example">this should be translated</p>',
    ],
    'translate-example' => [
        'locator' => '.translate-example',
        'value'   => '{$_nodeValue}',

        'var' => [
            'default' => [
                'data-textdomain' => 'test',
            ],
            'helper' => [
                '_nodeValue' => [
                    'translate' => [
                        '__invoke' => [['{$_nodeValue}', '{$data-textdomain}']],
                    ],
                ],
            ],
        ],
    ],
];
