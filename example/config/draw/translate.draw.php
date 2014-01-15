<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

return array(
    'translate-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="translate-example">this should be translated</p>',
    ),
    'translate-example' => array(
        'locator' => '.translate-example',
        'value'   => '{$_nodeValue}',
        'var' => array(
            'default' => array(
                'data-textdomain' => 'test',
            ),
            'helper' => array(
                '_nodeValue' => array(
                    'translate' => array(
                        '__invoke' => array(array('{$_nodeValue}', '{$data-textdomain}')),
                    ),
                ),
            ),
        ),
    ),
);
