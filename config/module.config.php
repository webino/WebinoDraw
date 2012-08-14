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
        'doctype'      => 'XHTML', // !!!XML REQUIRED
        'strategies'   => array('ViewDrawStrategy'),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/webino.html',
        ),
    ),
);
