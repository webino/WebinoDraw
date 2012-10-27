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
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(array(

            'viewvar' => 'TESTVIEWVAR',

            'value' => array(
                'in' => array(
                    'the' => array(
                        'depth' => 'DEPTHVAR',
                    ),
                ),
            ),

            'items' => array(
                'item0' => array(
                    'property' => 'value0',
                ),
                'item1' => array(
                    'property' => 'value1',
                ),
                'item3' => array(
                    'property' => 'value3',
                ),
            ),
        ));
    }
}
