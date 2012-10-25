<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'drawElement' => 'WebinoDraw\View\Helper\DrawElement',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ViewDrawStrategy' => 'WebinoDraw\Mvc\Service\ViewDrawStrategyFactory',
        ),
    ),
    'view_manager' => array(
        'doctype'    => 'XHTML5', // !!!XML REQUIRED
        'strategies' => array('ViewDrawStrategy'),
    ),
);
