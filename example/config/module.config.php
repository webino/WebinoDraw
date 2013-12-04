<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

/**
* WebinoDraw example configuration
*/
return array(
    'webino_draw' => array(
        /**
         * Override ajax settings
         */
        'ajax_container_xpath' => '//body',
        'ajax_fragment_xpath' => '//*[contains(@class, "ajax-fragment") and @id]',
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
            require __DIR__ . '/draw/filter.draw.php',
            require __DIR__ . '/draw/translate.draw.php',
            require __DIR__ . '/draw/loop.draw.php',
            require __DIR__ . '/draw/form.draw.php',
            require __DIR__ . '/draw/runtime.draw.php',
            require __DIR__ . '/draw/event.draw.php',
            require __DIR__ . '/draw/subInstructions.draw.php',
            require __DIR__ . '/draw/ajax.draw.php',
            require __DIR__ . '/draw/cache.draw.php'
        ),
        /**
         * The Instruction Set Example
         */
        'instructionset' => array(
            'exampleinstructionset_01' => array(),
            'exampleinstructionset_02' => array(),
        ),
    ),
    /**
     * Create Form via DI
     *
     * @deprecated Use form factory instead
     */
    'di' => array(
        'instance' => array(
            'alias' => array(
                'exampleForm' => 'WebinoDraw\Form\DiForm',
            ),
            'exampleForm' => array(
                'parameters' => array(
                    'config' => array(
                        'hydrator' => 'Zend\Stdlib\Hydrator\ArraySerializable',
                        'attributes' => array(
                            'method' => 'post',
                            'class' => 'example-form',
                        ),
                        'elements' => array(
                            array(
                                'spec' => array(
                                    'name' => 'example_text_element',
                                    'options' => array(
                                        'label' => 'Label example',
                                    ),
                                    'attributes' => array(
                                        'type' => 'text',
                                        'placeholder' => 'Type something ...',
                                    ),
                                ),
                            ),
                            array(
                                'spec' => array(
                                    'name' => 'example_text_element2',
                                    'options' => array(
                                        'label' => 'Label example2',
                                    ),
                                    'attributes' => array(
                                        'type' => 'text',
                                        'placeholder' => 'Type something2 ...',
                                    ),
                                ),
                            ),
                            array(
                                'spec' => array(
                                    'type' => 'Zend\Form\Element\Csrf',
                                    'name' => 'security',
                                ),
                            ),
                            array(
                                'spec' => array(
                                    'name' => 'send',
                                    'attributes' => array(
                                        'type' => 'submit',
                                        'value' => 'Submit',
                                    ),
                                ),
                            ),
                        ),
                        'input_filter' => array(
                            'example_text_element' => array(
                                'name' => 'example_text_element',
                                'required' => true,
                                'validators' => array(
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
