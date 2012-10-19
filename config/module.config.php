<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'ViewDrawStrategy' => 'Webino\View\Strategy\DrawStrategy',

                /**
                 * Default draw helpers
                 */
                'DrawElement' => 'Webino\Draw\Helper\Element',
            ),

            /**
             * DrawElement
             */
            'Webino\Draw\Helper\Element' => array(
                'parameters' => array(
                    'varTranslator' => 'Webino\View\Helper\VarTranslator',
                ),
            ),

            /**
             * ViewDrawStrategy
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
        'strategies' => array('ViewDrawStrategy'),
    ),
);
