<?php
return array(
    'router' => array(
        'routes' => array(

            'example-form-route' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/example/form/route',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'save',
                    ),
                ),
            ),
            'heavy-test-route' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/heavy',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'heavy',
                    ),
                ),
            ),
        ),
    ),

    'webino_draw' => array(
        'instructions' => array(

            'heavy-test-link' => array(
                'locator' => '.nav li[1]',
                'html' => '{$_html}<li><a href="{$href}">HEAVY TEST</a></li>',
                'var' => array(
                    'set' => array(
                        'href' => '',
                    ),
                    'helper' => array(
                        'href' => array(
                            'url' => array(
                                '__invoke' => array(
                                    array('heavy-test-route'),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'application/index/heavy' => __DIR__ . '/view/application/index/heavy.html',
        ),
    ),

    'translator' => array(
        'translation_files' => array(
            array(
                'type' => 'phparray',
                'filename' => current(glob(__DIR__ . '/../../._test/ZendSkeletonApplication/vendor/*/zendframework/resources/languages/sk/Zend_Validate.php')),
                'locale' => 'sk_SK',
            ),
        ),
    ),

    'zenddevelopertools' => array(
         /**
          * General Profiler settings
          */
        'profiler' => array(
            /**
             * Enables or disables the profiler.
             *
             * Expects: boolean
             * Default: false
             */
            'enabled' => true,

            /**
             * Enables or disables the strict mode. If the strict mode is
             * enabled, any error will throw an exception, otherwise all
             * errors will be added to the report (and shown in the toolbar).
             *
             * Expects: boolean
             * Default: true
             */
            'strict' => false,

            /**
             * If enabled, the profiler tries to flush the content before the it
             * starts collecting data. This option will be ignored if the Toolbar
             * is enabled.
             *
             * Note: The flush listener listens to the MvcEvent::EVENT_FINISH event
             *       with a priority of -9400. You have to disbale this function if
             *       you wish to modify the output with a lower priority.
             *
             * Expects: boolean
             * Default: false
             */
            'flush_early' => false,

            /**
             * The cache directory is used in the version check and for every storage
             * type that writes to the disk.
             *
             * Note: The default value assumes that the current working directory is the
             *       application root.
             *
             * Expects: string
             * Default: 'data/cache'
             */
            'cache_dir' => 'data/cache',

            /**
             * If a matches is defined, the profiler will be disabled if the
             * request does not match the pattern.
             *
             * Example: 'matcher' => array('ip' => '127.0.0.1')
             *          OR
             *          'matcher' => array('url' => array('path' => '/admin')
             *
             * Note: The matcher is not implemented yet!
             */
            'matcher' => array(),

            /**
             * Contains a list with all collector the profiler should run.
             * Zend Developer Tools ships with 'db' (Zend\Db), 'time', 'event', 'memory',
             * 'exception', 'request' and 'mail' (Zend\Mail). If you wish to disable a default
             * collector, simply set the value to null or false.
             *
             * Example: 'collectors' => array('db' => null)
             *
             * Expects: array
             */
            'collectors' => array(
                 'db' => null,
            ),
        ),
         /**
          * General Toolbar settings
          */
        'toolbar' => array(
            /**
             * Enables or disables the Toolbar.
             *
             * Expects: boolean
             * Default: false
             */
            'enabled' => true,

            /**
             * If enabled, every empty collector will be hidden.
             *
             * Expects: boolean
             * Default: false
             */
            'auto_hide' => false,

            /**
             * The Toolbar position.
             *
             * Expects: string ('bottom' or 'top')
             * Default: bottom
             */
            'position' => 'bottom',

            /**
             * If enabled, the Toolbar will check if your current Zend Framework version
             * is up-to-date.
             *
             * Note: The check will only occur once every hour.
             *
             * Expects: boolean
             * Default: false
             */
            'version_check' => true,

            /**
             * Contains a list with all collector toolbar templates. The name
             * of the array key must be same as the name of the collector.
             *             *
             * Example: 'profiler' => array(
             *              'collectors' => array(
             *                  // My_Collector_Example::getName() -> mycollector
             *                  'MyCollector' => 'My_Collector_Example',
             *              )
             *          ),
             *          'toolbar' => array(
             *              'entries' => array(
             *                  'mycollector' => 'example/toolbar/my-collector',
             *              )
             *          ),
             *
             * Expects: array
             */
            'entries' => array(),
        ),
    ),
);
