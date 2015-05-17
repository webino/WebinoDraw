<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use Zend\Form\Element\Csrf;
use Zend\Stdlib\Hydrator\ArraySerializable;

/**
* WebinoDraw example configuration
*/
return [
    'webino_draw' => [
        /**
         * Override ajax settings
         */
        'ajax_container_xpath' => '//body',
        'ajax_fragment_xpath'  => '//*[contains(@class, "ajax-fragment") and @id]',

        /**
         * The Draw Instructions Example
         */
        'instructions' => array_merge(
            // todo render example
            // todo content example
            // todo complex xpath example
            // todo table example
            require __DIR__ . '/draw/absolutize.draw.php',
            require __DIR__ . '/draw/value.draw.php',
            require __DIR__ . '/draw/html.draw.php',
            require __DIR__ . '/draw/replace.draw.php',
            require __DIR__ . '/draw/add.draw.php',
            require __DIR__ . '/draw/remove.draw.php',
            require __DIR__ . '/draw/var.draw.php',
            require __DIR__ . '/draw/onVar.draw.php',
            require __DIR__ . '/draw/filter.draw.php',
            require __DIR__ . '/draw/translate.draw.php',
            require __DIR__ . '/draw/loop.draw.php',
            require __DIR__ . '/draw/form.draw.php',
            require __DIR__ . '/draw/runtime.draw.php',
            require __DIR__ . '/draw/event.draw.php',
            require __DIR__ . '/draw/subInstructions.draw.php',
            require __DIR__ . '/draw/ajax.draw.php',
            require __DIR__ . '/draw/cache.draw.php',
            require __DIR__ . '/draw/locator-var.draw.php',
            require __DIR__ . '/draw/custom-helper.draw.php',
            require __DIR__ . '/draw/pagination.draw.php'
        ),

        /**
         * The Instruction Set Example
         */
        'instructionset' => [
            'exampleinstructionset_01' => [],
            'exampleinstructionset_02' => [],
        ],
    ],

    /**
     * Example Form
     */
    'forms' => [
        'exampleForm' => [
            'hydrator' => ArraySerializable::class,
            'attributes' => [
                'method' => 'post',
                'class'  => 'example-form',
            ],
            'elements' => [
                'example_text_element'=> [
                    'spec' => [
                        'name' => 'example_text_element',
                        'type' => 'text',

                        'options' => [
                            'label' => 'Label example',
                            'view_helper' => 'FormTextarea',
                        ],
                        'attributes' => [
                            'type'        => 'text',
                            'placeholder' => 'Type something ...',
                        ],
                    ],
                ],
                'example_text_element2' => [
                    'spec' => [
                        'name' => 'example_text_element2',
                        'type' => 'text',

                        'options' => [
                            'label' => 'Label example2',
                        ],
                        'attributes' => [
                            'type'        => 'text',
                            'placeholder' => 'Type something2 ...',
                        ],
                    ],
                ],
                'security' => [
                    'spec' => [
                        'name' => 'security',
                        'type' => Csrf::class,
                    ],
                ],
                'send' => [
                    'spec' => [
                        'name'  => 'send',
                        'type'  => 'submit',

                        'attributes' => [
                            'value' => 'Submit',
                        ],
                    ],
                ],
            ],
            'input_filter' => [
                'example_text_element' => [
                    'name'     => 'example_text_element',
                    'required' => true,
                ],
            ],
        ],
    ],
];
