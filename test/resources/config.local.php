<?php
return array(
    'router' => array(
        'routes' => array(
            'example_form_route' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/example/form/route',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'save',
                    ),
                ),
            ),
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
);
