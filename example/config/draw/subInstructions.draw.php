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
    'subInstructions-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="subinstructions-example"><span>SUB-INSTRUCTIONS</span> <strong>EXAMPLE</strong> <form/></div>',
    ),
    'subInstructions-example' => array(
        'locator'      => '.subinstructions-example',
        'instructions' => array(
            'subtest1' => array(
                'stackIndex' => '99',
                'locator'    => 'span',
                'value'      => '{$_nodeValue}(TEST)',
            ),
            'subtest2' => array(
                'locator' => 'xpath=.//strong',
                'value'   => '{$_nodeValue} VALUE',
            ),
            'subtest-form' => array(
                'locator'     => 'form',
                'helper'      => 'WebinoDrawForm',
                'form'        => 'exampleForm',
                'route'       => 'example-form-route',
                'text_domain' => 'test',
                'instructions' => array(
                    'form-decorator1' => array(
                        'locator' => 'label span',
                        'value'   => '{$_nodeValue}*',
                    ),
                ),
            ),
        ),
    ),
);
