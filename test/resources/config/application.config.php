<?php
return array(
    'modules' => array(
        // 'ZF2NetteDebug', // todo: conflict with nett library
        'ZendDeveloperTools',
        'Application',
        'WebinoDraw',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'config_static_paths'    => array(
            __DIR__ . '/config.local.php',
        ),
        'module_paths' => array(
            'WebinoDraw' => __DIR__ . '/../../src',
            './module',
            './vendor',
        ),
    ),
);
