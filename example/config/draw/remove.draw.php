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
    'remove-single-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="remove-me-single">THIS SHOULD BE REMOVED SINGLE</p>',
    ),
    'remove-single-example' => array(
        'locator' => '.remove-me-single',
        'remove'  => 'xpath=.',
    ),
    'remove-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="remove-me">THIS SHOULD BE REMOVED</p><p class="remove-me-xpath">THIS SHOULD BE REMOVED BY XPATH</p>',
    ),
    'remove-example' => array(
        'locator' => 'body',
        'remove'  => array(
            '.remove-me',
            'xpath=//*[@class="remove-me-xpath"]',
        ),
    ),
);
