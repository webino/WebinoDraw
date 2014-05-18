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

/**
 * Initialize test resources autoloader
 */
require __DIR__ . '/../init_autoloader.php';

/**
 * WebinoDraw application test config
 */
return [
    'modules' => [
         'ZF2NetteDebug', // todo: conflict with nette library
//        'ZendDeveloperTools',
        'Application',
        'WebinoDraw',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'config_static_paths' => [
            __DIR__ . '/module.config.php',
            __DIR__ . '/../../../example/config/module.config.php',
        ],
        'module_paths' => [
            'WebinoDraw' => __DIR__ . '/../../src',
            'module',
            'vendor',
        ],
    ],
];
