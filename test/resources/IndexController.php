<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
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
                    'property0' => 'value00',
                    'property1' => 'value01',
                    'childs'    => array(
                        'property00' => 'value010',
                        'property01' => 'value011',
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
        ));
    }
}
