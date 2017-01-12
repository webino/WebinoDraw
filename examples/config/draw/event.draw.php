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
    'event-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="event-example">EVENT EXAMPLE</div>',
    ],
    'event-example' => [
        'locator' => '.event-example',
        'trigger' => [
            'event-example.test',
        ],
    ],
];
