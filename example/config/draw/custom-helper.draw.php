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
    'custom-helper-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="custom-helper-example"></div><div class="custom-dihelper-example"></div>',
    ],
    'custom-helper-example' => [
        'locator' => '.custom-helper-example',
        'helper'  => 'CustomHelper',
    ],
    'custom-dihelper-example' => [
        'locator' => '.custom-dihelper-example',
        'helper'  => 'CustomDiHelper',
    ],
];
