<?php

return array(
    'di' => array(
        'definition' => array(
            'compiler' => array(
                __DIR__ . '/../data/di/definition.php',
                __DIR__ . '/../data/di/DiForm.definition.php',
            ),
            'class' => array(
                'WebinoDraw\View\Helper\DrawForm' => array(
                    'methods' => array(
                        'setTranslatorTextDomain' => array(
                            'textDomain' => array('default' => null),
                        ),
                        'setRenderErrors' => array(
                            'bool' => array('default' => null),
                        ),
                    ),
                ),
            ),
        ),
        'instance' => array(
            'alias' => array(
                'WebinoDraw' => 'WebinoDraw\WebinoDraw',
                'WebinoDrawElement' => 'WebinoDraw\View\Helper\DrawElement',
                'WebinoDrawForm' => 'WebinoDraw\View\Helper\DrawForm',
                'WebinoDrawPagination' => 'WebinoDraw\View\Helper\DrawPagination',
                'WebinoDrawCache' => 'Zend\Cache\Storage\Adapter\Filesystem',
            ),
            'WebinoDrawElement' => array(
                'injections' => array(
                    'FilterManager',
                    'WebinoDrawCache',
                ),
            ),
            'WebinoDrawForm' => array(
                'injections' => array(
                    'FilterManager',
                    'WebinoDrawCache',
                ),
            ),
            'WebinoDrawPagination' => array(
                'injections' => array(
                    'FilterManager',
                    'WebinoDrawCache',
                ),
            ),
            'WebinoDrawCache' => array(
                'parameters' => array(
                    'options' => array(
                        'namespace' => 'webinodraw',
                        'cacheDir' => 'data/cache',
                    ),
                ),
            ),
            'WebinoDraw\Form\DiForm' => array(
                'parameters' => array(
                    'formFactory' => 'FormFactory',
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'WebinoDraw' => 'WebinoDraw\Mvc\Service\WebinoDrawFactory',
            'WebinoDrawStrategy' => 'WebinoDraw\Mvc\Service\DrawStrategyFactory',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'WebinoDrawElement' => 'WebinoDraw\Mvc\Service\ServiceViewHelperFactory',
            'WebinoDrawForm' => 'WebinoDraw\Mvc\Service\ServiceViewHelperFactory',
            'WebinoDrawPagination' => 'WebinoDraw\Mvc\Service\ServiceViewHelperFactory',
        ),
        'invokables' => array(
            'WebinoDrawAbsolutize' => 'WebinoDraw\View\Helper\DrawAbsolutize',
            'WebinoDrawTranslate' => 'WebinoDraw\View\Helper\DrawTranslate',
            'WebinoDrawFormRow' => 'WebinoDraw\Form\View\Helper\FormRow',
            'WebinoDrawFormElement' => 'WebinoDraw\Form\View\Helper\FormElement',
            'WebinoDrawFormCollection' => 'WebinoDraw\Form\View\Helper\FormCollection',
        ),
    ),
    'view_manager' => array(
        'doctype' => 'XHTML5', // !!!XML REQUIRED
        'strategies' => array('WebinoDrawStrategy'),
        'template_map' => array(
            'webino-draw/snippet/pagination' => __DIR__ . '/../view/webino-draw/snippet/pagination.html',
        ),
    ),
);
