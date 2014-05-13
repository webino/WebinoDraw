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

use WebinoDraw\View\Helper\DrawAbsolutize;

return [
    'absolutize-example-prepare' => [
        'stackIndex' => 9999997,
        'locator'    => 'head',
        'html'       => '{$_innerHtml}<script src="./test-script-relative.js"></script><link href="test-link-relative.css"/>',

        'instructions' => [
            'form-preapare' => [
                'locator' => 'xpath=//body',
                'html'    => '<form action="../../test-action-relative"/>{$_innerHtml}'
            ],
        ],
    ],
    'absolutize-example' => [
        'stackIndex' => 9999998,
        'helper'     => 'WebinoDrawAbsolutize',
        'locator'    => DrawAbsolutize::getDefaultLocator(),
    ],
];
