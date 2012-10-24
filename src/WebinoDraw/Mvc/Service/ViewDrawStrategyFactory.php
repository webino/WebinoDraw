<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Service
 */

namespace WebinoDraw\Mvc\Service;

use WebinoDraw\Dom\Draw;
use WebinoDraw\View\Strategy\DrawStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package     WebinoDraw
 * @subpackage  WebinoDraw_Service
 */
class ViewDrawStrategyFactory implements FactoryInterface
{
    /**
     * Create the ViewDrawStrategy
     *
     * Creates a Webino\View\Strategy\DrawStrategy and populates it with the
     * ['webino_draw']['instructions'] and ['webino_draw']['instructionset']
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return WebinoDraw\View\Strategy\DrawStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config       = $serviceLocator->get('Config');
        $viewRenderer = $serviceLocator->get('ViewRenderer');
        $drawStrategy = new DrawStrategy(new Draw($viewRenderer));

        empty($config['webino_draw']['instructions']) or
            $drawStrategy->setInstructions($config['webino_draw']['instructions']);

        empty($config['webino_draw']['instructionset']) or
            $drawStrategy->setInstructionSet($config['webino_draw']['instructionset']);

        return $drawStrategy;
    }
}
