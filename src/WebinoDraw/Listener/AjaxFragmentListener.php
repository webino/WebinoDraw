<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Listener;

use WebinoDraw\Event\AjaxEvent;
use WebinoDraw\Service\DrawService;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\Http\Request;

/**
 * Class AjaxFragmentListener
 */
class AjaxFragmentListener implements SharedListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request|object $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param SharedEventManagerInterface $events
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            DrawService::SERVICE,
            AjaxEvent::EVENT_AJAX,
            [$this, 'ajaxFragment']
        );
    }

    /**
     * @param SharedEventManagerInterface $events
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach(DrawService::SERVICE, $listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * @param AjaxEvent $event
     */
    public function ajaxFragment(AjaxEvent $event)
    {
        $id = $this->request->getQuery()->fragmentId;
        empty($id) or $event->setFragmentXpath('//*[@id="' . $id . '"]');
    }
}
