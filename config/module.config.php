<?php

return array(
    'di' => array(
        'definition' => array(
            'compiler' => array(
                __DIR__ . '/../data/di/definition.php',
                __DIR__ . '/../data/di/DiForm.definition.php',
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
        'invokables' => array(
            'WebinoDrawFormRow' => 'WebinoDraw\Form\View\Helper\FormRow',
            'WebinoDrawFormElement' => 'WebinoDraw\Form\View\Helper\FormElement',
            'WebinoDrawElement' => 'WebinoDraw\View\Helper\DrawElement',
            'WebinoDrawForm' => 'WebinoDraw\View\Helper\DrawForm',
        ),
    ),
    'view_manager' => array(
        'doctype' => 'XHTML5', // !!!XML REQUIRED
        'strategies' => array('WebinoDrawStrategy'),
    ),
);
