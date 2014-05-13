<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

return [
    'loop-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<ul class="loop-example"><li>BEFORE</li><li/><li>AFTER</li></ul>',
    ],
    'loop-example' => [
        'locator' => '.loop-example li[2]',
        'html'    => '<strong/> <span/>',

        'loop' => [
            'base'   => 'depth.items',
            'index'  => '0',
            'offset' => '1',
            'length' => '3',

            'onEmpty' => [
                'locator' => '.loop-example',
                'replace' => '<p>YOU HAVE NO ITEMS</p>',
            ],
            'instructions' => [
                'loop-example-strong-node' => [
                    'locator' => 'strong',
                    'value'   => '{$_key} {$_index} {$property0} {$test}',

                    'var' => [
                        'fetch' => [
                            'test' => 'childs.item00.property0'
                        ],
                    ],
                ],
                'loop-example-span-node' => [
                    'locator' => 'span',
                    'value'   => 'TADA',
                ],
            ],
        ],
        'attribs' => [
            'title' => '{$property1}',
        ],
    ],
    'loop-empty-example-prepare' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<ul class="loop-empty-example"><li>BEFORE</li><li/><li>AFTER</li></ul>',
    ],
    'loop-empty-example' => [
        'locator' => '.loop-empty-example li[2]',

        'loop' => [
            'base' => 'depth.items-empty',

            'onEmpty' => [
                'locator' => '//.loop-empty-example',
                'replace' => '<p>YOU HAVE NO ITEMS</p>',
            ],
            'instructions' => [],
        ],
    ],
];
