<?php

return array(
    'WebinoDraw\Form\DiForm' =>
    array(
        'supertypes' =>
        array(
            'Zend\Form\FormFactoryAwareInterface',
        ),
        'instantiator' => '__construct',
        'methods' =>
        array(
            '__construct' => true,
            'setFormFactory' => true,
        ),
        'parameters' =>
        array(
            '__construct' =>
            array(
                'WebinoDraw\Form\DiForm::__construct:0' =>
                array(
                    0 => 'config',
                    1 => NULL,
                    2 => true,
                    3 => NULL,
                ),
            ),
            'setFormFactory' =>
            array(
                'WebinoDraw\Form\DiForm::setFormFactory:0' =>
                array(
                    0 => 'factory',
                    1 => 'Zend\Form\Factory',
                    2 => true,
                    3 => NULL,
                ),
            ),
        ),
    ),
);
