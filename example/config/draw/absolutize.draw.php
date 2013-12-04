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
    'absolutize-example-prepare' => array(
        'stackIndex'   => '9999997',
        'locator'      => 'head',
        'html'         => '{$_innerHtml}<script src="./test-script-relative.js"></script><link href="test-link-relative.css"/>',
        'instructions' => array(
            'form-preapare' => array(
                'locator' => 'xpath=//body',
                'html'    => '<form action="../../test-action-relative"/>{$_innerHtml}'
            ),
        ),
    ),
    'absolutize-example' => array(
        'stackIndex' => '9999998',
        'helper'     => 'WebinoDrawAbsolutize',
        'locator'    => \WebinoDraw\View\Helper\DrawAbsolutize::getDefaultLocator(),
    ),
);
