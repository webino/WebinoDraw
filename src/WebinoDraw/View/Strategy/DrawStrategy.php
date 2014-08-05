<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Strategy;

use Zend\Http\PhpEnvironment\Response;
use Zend\View\ViewEvent;

/**
 * Draw XHTML with this view strategy
 */
class DrawStrategy extends AbstractDrawStrategy
{
    /**
     * @param ViewEvent $event
     */
    public function injectResponse(ViewEvent $event)
    {
        if (!$this->shouldRespond($event)) {
            return;
        }

        $options  = $this->draw->getOptions();
        /* @var $response \Zend\Http\Response */
        $response = $event->getResponse();

        $response->setContent(
            $this->draw->draw(
                $response->getBody(),
                $options->getInstructions(),
                $this->collectModelVariables($event->getModel()),
                $this->resolveIsXml($response)
            )
        );
    }

    /**
     * @param Response $response
     * @return bool
     */
    private function resolveIsXml(Response $response)
    {
        $contentType = $response->getHeaders()->get('content-type');
        if (empty($contentType)) {
            return false;
        }

        return ('text/xml' === $contentType->getMediaType());
    }
}
