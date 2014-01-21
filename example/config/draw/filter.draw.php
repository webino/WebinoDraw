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
    'filter-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<p class="filter-example">-this should be upper case-</p>',
    ),
    'filter-example'         => array(
        'locator' => '.filter-example',
        'value'   => '{$_nodeValue}',
        'var' => array(
            'filter' => array(
                'pre' => array(
                    '_nodeValue' => array(
                        'stringToUpper' => array(
                            '{$_nodeValue}'
                        ),
                        'trim' => array(
                            '{$_nodeValue}', '-'
                        ),
                    ),
                ),
            ),
        ),
    ),
);
