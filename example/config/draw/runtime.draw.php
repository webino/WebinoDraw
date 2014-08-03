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
    'runtime-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="runtime-example">RUNTIME EXAMPLE</div>',
    ],
    /**
     * Options for this node are set
     * from action controller
     *
     * Check out test action controller.
     */
    'runtime-example' => [
        'locator' => '.runtime-example',
        'helper'  => 'WebinoDrawElement',
    ],
];
