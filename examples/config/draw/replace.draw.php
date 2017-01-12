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
    'replace-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '<strong class="replace-example">REPLACE PREPARE</strong>{$_innerHtml}',
    ],
    'replace-example' => [
        'locator' => '.replace-example',
        'replace' => '<strong>TEST REPLACE</strong>',

        'attribs' => [
            'class' => '{$_class}',
        ],
    ],
];