<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

return array(
    'nodevar-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<h2 data-webino-test="ORIGATTRIB">ORIGCONTENT</h2>',
    ),
    'nodevar-example' => array(
        'locator' => '.jumbotron h2',
        'value'   => '{$value}',
        'var' => array(
            'set' => array(
                'value' => '{$_nodeValue} NODEVARTEST {$_data-webino-test}',
                'title' => '{$_nodeValue} NODEVARATTRIBTEST {$_data-webino-test}',
            ),
        ),
        'attribs' => array(
            'title' => '{$title}',
        ),
    ),
    'viewvar-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="viewvar-example"/>',
    ),
    'viewvar-example' => array(
        'locator' => '.viewvar-example',
        'value'   => '{$viewvar} {$depthvar}',
        'var' => array(
            'fetch' => array(
                'depthvar' => 'value.in.the.depth',
            ),
        ),
    ),
);
