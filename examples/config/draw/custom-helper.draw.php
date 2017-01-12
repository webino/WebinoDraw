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
    'custom-helper-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="custom-helper-example">'
                     . '</div><div class="custom-di-helper-example"></div>',
    ],
    'custom-helper-example' => [
        'locator' => '.custom-helper-example',
        'helper'  => 'CustomHelper',
    ],
    'custom-di-helper-example' => [
        'locator' => '.custom-di-helper-example',
        'helper'  => 'CustomDiHelper',
    ],
];
