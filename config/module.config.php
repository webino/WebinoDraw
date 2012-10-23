<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ViewDrawStrategy' => 'WebinoDraw\Service\ViewDrawStrategyFactory',
        ),
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'drawElement' => 'WebinoDraw\View\Helper\DrawElement',
            ),
            'WebinoDraw\View\Helper\Element' => array(
                'parameters' => array(
                    'varTranslator' => 'WebinoDraw\View\Helper\VarTranslator',
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'doctype'    => 'XHTML5', // !!!XML REQUIRED
        'strategies' => array('ViewDrawStrategy'),
    ),
);
