<?php

return array(
    'di' => array(
        'definition' => array(
            'compiler' => array(
                __DIR__ . '/../data/di/definition.php',
                __DIR__ . '/../data/di/MagicForm.definition.php',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ViewDrawStrategy' => 'WebinoDraw\Mvc\Service\ViewDrawStrategyFactory',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'MagicFormRow' => 'WebinoDraw\Form\View\Helper\MagicFormRow',
            'MagicFormElement' => 'WebinoDraw\Form\View\Helper\MagicFormElement',
            'DrawElement' => 'WebinoDraw\View\Helper\DrawElement',
            'DrawForm' => 'WebinoDraw\View\Helper\DrawForm',
        ),
    ),
    'view_manager' => array(
        'doctype' => 'XHTML5', // !!!XML REQUIRED
        'strategies' => array('ViewDrawStrategy'),
    ),
);
