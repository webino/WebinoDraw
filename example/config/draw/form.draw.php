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
    'form-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<form class="form-example"/>',
    ),
    'form-example' => array(
        'locator'     => '.form-example',
        'helper'      => 'WebinoDrawForm',
        'form'        => 'exampleForm',
        'route'       => 'example-form-route',
        'text_domain' => 'test',
        'trigger' => array(
            'form-example.event',
        ),
    ),
    'form-template-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<form class="form-template-example"><ul><li><input name="example_text_element"/></li><li><input name="example_text_element2"/></li></ul><input name="send"/></form>',
    ),
    'form-template-example' => array(
        'locator'      => '.form-template-example',
        'helper'       => 'WebinoDrawForm',
        'form'         => 'exampleForm',
        'instructions' => array(
            'form-decorator' => array(
                'locator' => 'xpath=.//li//input/..',
                'html'    => 'LABEL {$_innerHtml}',
            ),
        ),
    ),
);
