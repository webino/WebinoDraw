<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Mvc
 */

namespace WebinoDraw\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebinoDraw\View\Strategy\DrawStrategy;

class ViewDrawStrategyFactory implements FactoryInterface
{
    /**
     * Create the template map view resolver
     *
     * Creates a Zend\View\Resolver\AggregateResolver and populates it with the
     * ['view_manager']['template_map']
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ViewResolver\TemplateMapResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config       = $serviceLocator->get('Config');
        $viewRenderer = $serviceLocator->get('ViewRenderer');
        $drawStrategy = new DrawStrategy($viewRenderer);
        
        empty($config['webino_draw']['instructions']) or
            $drawStrategy->setInstructions($config['webino_draw']['instructions']);
        
        empty($config['webino_draw']['instructionset']) or
            $drawStrategy->setInstructionSet($config['webino_draw']['instructionset']);
        
        return $drawStrategy;
    }
}
