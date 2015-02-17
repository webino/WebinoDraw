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
    'nodevar-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<h2 data-webino-test="ORIGATTRIB">ORIGCONTENT</h2>',
    ],
    'nodevar-example' => [
        'locator' => '.jumbotron h2',
        'value'   => '{$value}',

        'var' => [
            'set' => [
                'value' => '{$_nodeValue} NODEVARTEST {$_data-webino-test}',
                'title' => '{$_nodeValue} NODEVARATTRIBTEST {$_data-webino-test}',
            ],
        ],
        'attribs' => [
            'title' => '{$title}',
        ],
    ],
    'viewvar-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="viewvar-example"/>',
    ],
    'viewvar-example' => [
        'locator' => '.viewvar-example',
        'value'   => '{$viewvar} {$depthvar}',

        'var' => [
            'fetch' => [
                'depthvar' => 'value.in.the.depth',
            ],
        ],
    ],
];
