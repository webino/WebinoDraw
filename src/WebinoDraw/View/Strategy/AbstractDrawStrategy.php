<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Strategy;

use WebinoDraw\WebinoDraw as DrawService;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Strategy\PhpRendererStrategy;
use Zend\View\ViewEvent;

/**
 * Draw XHTML with this view strategy
 */
abstract class AbstractDrawStrategy extends PhpRendererStrategy
{
    /**
     * @var WebinoDraw $service
     */
    protected $service;

    /**
     * @param WebinoDraw $service
     */
    public function __construct(DrawService $service)
    {
        $this->service = $service;
    }

    /**
     * Attach the aggregate to the specified event manager.
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        parent::attach($events, $priority - 100); // as last
    }

    /**
     * @param ViewEvent $event
     * @return bool
     */
    public function shouldRespond(ViewEvent $event)
    {
        if ($event->getRenderer() instanceof PhpRenderer
            && trim($event->getResponse()->getBody())
        ) {
            return true;
        }

        return false;
    }

    /**
     * Collect all variables from the view model
     *
     * @param ViewModel $model
     * @return array
     */
    public function collectModelVariables(ViewModel $model)
    {
        $vars = $model->getVariables()->getArrayCopy();

        foreach ($model->getChildren() as $child) {

            $childVars = $child->getVariables();

            !method_exists($childVars, 'getArrayCopy') or
                $childVars = $childVars->getArrayCopy();

            $vars = array_replace($vars, $childVars);
        }

        return $vars;
    }
}