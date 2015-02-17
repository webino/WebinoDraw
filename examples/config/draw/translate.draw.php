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

    'translate-draw-helper-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="translate-draw-helper-example"'
                     . ' title="this should be translated by draw helper">'
                     . ' this should be translated by draw helper</p>',
    ],
    'translate-draw-helper-example' => [
        'locator'     => '.translate-draw-helper-example',
        'helper'      => 'WebinoDrawTranslate',
        'text_domain' => 'test',
        'value'       => '{$_nodeValue}',

        'attribs' => [
            'title' => '{$_title}',
        ],
    ],
];
