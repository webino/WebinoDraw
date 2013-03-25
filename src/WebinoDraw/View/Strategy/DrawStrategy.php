<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Strategy;

use Zend\View\ViewEvent;

/**
 * Draw XHTML with this view strategy
 */
class DrawStrategy extends AbstractDrawStrategy
{
    /**
     * @param ViewEvent $event
     * @return bool Exit
     */
    public function injectResponse(ViewEvent $event)
    {
        if (!$this->shouldRespond($event)) {
            return;
        }

        $options  = $this->service->getOptions();
        $response = $event->getResponse();
        $dom      = $this->service->createDom($response->getBody());

        $this->service->drawDom(
            $dom->documentElement,
            $options->getInstructions(),
            $this->collectModelVariables($event->getModel())
        );

        $response->setContent($dom->saveHTML());
    }
}
