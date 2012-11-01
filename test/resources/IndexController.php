<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * WebinoDraw  test application controller.
 */
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return array(

            'viewvar' => 'TESTVIEWVAR',

            'value' => array(
                'in' => array(
                    'the' => array(
                        'depth' => 'DEPTHVAR',
                    ),
                ),
            ),

            'depth' => array(
                'items' => array(
                    'item0' => array(
                        'property0' => 'value00',
                        'property1' => 'value01',
                        'childs'    => array(
                            'item00' => array(
                                'property0' => 'value000',
                                'property1' => 'value001',
                            ),
                            'item01' => array(
                                'property0' => 'value010',
                                'property1' => 'value011',
                            ),
                        ),
                    ),
                    'item1' => array(
                        'property0' => 'value10',
                        'property1' => 'value11',
                    ),
                    'item3' => array(
                        'property0' => 'value30',
                        'property1' => 'value31',
                    ),
                ),
            ),
        );
    }
}
