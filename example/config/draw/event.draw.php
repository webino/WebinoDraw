<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

return array(
    'event-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="event-example">EVENT EXAMPLE</div>',
    ),
    'event-example' => array(
        'locator' => '.event-example',
        'trigger' => array(
            'event-example.test',
        ),
    ),
);
