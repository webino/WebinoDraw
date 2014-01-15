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
    'loop-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<ul class="loop-example"><li>BEFORE</li><li/><li>AFTER</li></ul>',
    ),
    'loop-example' => array(
        'locator' => '.loop-example li[2]',
        'html'    => '<strong/> <span/>',
        'loop' => array(
            'base'   => 'depth.items',
            'index'  => '0',
            'offset' => '1',
            'length' => '3',
            'onEmpty' => array(
                'locator' => '.loop-example',
                'replace' => '<p>YOU HAVE NO ITEMS</p>',
            ),
            'instructions' => array(
                'loop-example-strong-node' => array(
                    'locator' => 'strong',
                    'value'   => '{$_key} {$_index} {$property0} {$test}',
                    'var' => array(
                        'fetch' => array(
                            'test' => 'childs.item00.property0'
                        ),
                    ),
                ),
                'loop-example-span-node' => array(
                    'locator' => 'span',
                    'value'   => 'TADA',
                ),
            ),
        ),
        'attribs' => array(
            'title' => '{$property1}',
        ),
    ),
    'loop-empty-example-prepare' => array(
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<ul class="loop-empty-example"><li>BEFORE</li><li/><li>AFTER</li></ul>',
    ),
    'loop-empty-example' => array(
        'locator' => '.loop-empty-example li[2]',
        'loop'    => array(
            'base' => 'depth.items-empty',
            'onEmpty' => array(
                'locator' => '//.loop-empty-example',
                'replace' => '<p>YOU HAVE NO ITEMS</p>',
            ),
            'instructions' => array(),
        ),
    ),
);
