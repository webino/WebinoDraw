<?php
return array(
    'WebinoDraw\\Instructions\\InstructionsRenderer' =>
    array(
        'supertypes'   =>
        array(
        ),
        'instantiator' => '__construct',
        'methods'      =>
        array(
            '__construct'   => 3,
            'setDrawHelper' => 0,
        ),
        'parameters'   =>
        array(
            '__construct'   =>
            array(
                'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:0' =>
                array(
                    0 => 'drawHelpers',
                    1 => 'WebinoDraw\\HelperPluginManager',
                    2 => true,
                    3 => NULL,
                ),
                'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:1' =>
                array(
                    0 => 'locator',
                    1 => 'WebinoDraw\\Dom\\Locator',
                    2 => true,
                    3 => NULL,
                ),
                'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:2' =>
                array(
                    0 => 'nodeListFactory',
                    1 => 'WebinoDraw\\Dom\\NodeListFactory',
                    2 => true,
                    3 => NULL,
                ),
                'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:3' =>
                array(
                    0 => 'instructionsFactory',
                    1 => 'WebinoDraw\\Instructions\\InstructionsFactory',
                    2 => true,
                    3 => NULL,
                ),
                'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:4' =>
                array(
                    0 => 'drawOptions',
                    1 => 'WebinoDraw\\WebinoDrawOptions',
                    2 => true,
                    3 => NULL,
                ),
            ),
            'setDrawHelper' =>
            array(
                'WebinoDraw\\Instructions\\InstructionsRenderer::setDrawHelper:0' =>
                array(
                    0 => 'helper',
                    1 => 'WebinoDraw\\Helper\\DrawHelperInterface',
                    2 => true,
                    3 => NULL,
                ),
                'WebinoDraw\\Instructions\\InstructionsRenderer::setDrawHelper:1' =>
                array(
                    0 => 'name',
                    1 => false,
                    2 => true,
                    3 => NULL,
                ),
            ),
        ),
    ),
);
