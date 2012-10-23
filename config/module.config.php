<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'WebinoDrawStrategy' => 'Webino\View\Strategy\DrawStrategy',

                /**
                 * Default draw helpers
                 */
                'WebinoDrawElement' => 'Webino\Draw\Helper\Element',
            ),

            /**
             * WebinoDrawElement
             */
            'Webino\Draw\Helper\Element' => array(
                'parameters' => array(
                    'varTranslator' => 'Webino\View\Helper\VarTranslator',
                ),
            ),

            /**
             * WebinoDrawStrategy
             */
            'Webino\View\Strategy\DrawStrategy' => array(
                'parameters' => array(
                    'renderer' => 'Zend\View\Renderer\PhpRenderer',
                ),
            ),
           
        ),
    ),
    'view_manager' => array(
        'doctype'    => 'XHTML5', // !!!XML REQUIRED
        'strategies' => array('WebinoDrawStrategy'),
    ),
);
