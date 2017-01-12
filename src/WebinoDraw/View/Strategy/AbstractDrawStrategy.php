<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Strategy;

use WebinoDraw\Service\DrawService;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\PhpEnvironment\Response as PhpResponse;
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
     * @var DrawService $draw
     */
    protected $draw;

    /**
     * @param DrawService $draw
     */
    public function __construct(DrawService $draw)
    {
        $this->draw = $draw;
    }

    /**
     * @param EventManagerInterface $events
     * @param int $priority
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
        /* @var $response PhpResponse */
        $response = $event->getResponse();
        if ($event->getRenderer() instanceof PhpRenderer
            && $response instanceof PhpResponse
            && trim($response->getBody())
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
        $vars = (array) $model->getVariables();
        foreach ($model->getChildren() as $child) {
            $vars = array_replace($vars, $this->collectModelVariables($child));
        }

        return $vars;
    }
}
