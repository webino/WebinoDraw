<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

// Overrdides application controller
require __DIR__ . '/../IndexController.php';

/**
 * WebinoDraw application test config
 */
return array(
    'modules' => array(
        // 'ZF2NetteDebug', // todo: conflict with nette library
        'ZendDeveloperTools',
        'Application',
        'WebinoDraw',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'config_static_paths'    => array(
            __DIR__ . '/module.config.php',
            __DIR__ . '/../../../example/config/module.config.php',
        ),
        'module_paths' => array(
            'WebinoDraw' => __DIR__ . '/../../src',
            'module',
            'vendor',
        ),
    ),
);
