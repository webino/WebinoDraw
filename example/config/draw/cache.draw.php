<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

return array(
    'cache-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="cache-example"></div>',
    ),
    'cache-example' => array(
        'locator' => '.cache-example',
        'value'   => 'CACHED? {$rand}',
        'cache'   => 'example',
        'var' => array(
            'set' => array(
                'rand' => '',
            ),
            'helper' => array(
                'rand' => array(
                    'rand' => array(),
                ),
            ),
        ),
    ),
);
