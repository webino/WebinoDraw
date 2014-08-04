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

use WebinoDraw\Dom\Document;
use WebinoDraw\Event\AjaxEvent;
use WebinoDraw\Exception\RuntimeException;

/**
 * Draw matched containers and return the JSON XHTML of matched fragments
 */
class DrawAjaxJsonStrategy extends AbstractDrawAjaxStrategy
{
    /**
     * Return XHTML parts of nodes matched by XPath
     *
     * @param Document $dom
     * @param string $xpath
     * @return array
     * @throws Exception\RuntimeException
     */
    public function createFragments(Document $dom, $xpath)
    {
        $data = [];
        foreach ($dom->getXpath()->query($xpath) as $item) {

            $itemId = $item->getAttribute('id');
            if (empty($itemId)) {
                throw new RuntimeException('Required ajax fragment element id');
            }

            $data['fragment']['#' . $itemId] = $dom->saveHTML($item);
        }

        return $data;
    }

    /**
     * @param Document $dom
     * @param string $xpath
     * @return \WebinoDraw\Ajax\Json
     */
    protected function respond(Document $dom, $xpath)
    {
        $ajaxEvent = $this->getEvent();
        $ajaxEvent->setFragmentXpath($xpath);

        $this->getEventManager()->trigger(AjaxEvent::EVENT_AJAX, $ajaxEvent);

        return $ajaxEvent->getJson()
            ->merge($this->createFragments($dom, $ajaxEvent->getFragmentXpath()))
            ->jsonSerialize();
    }
}
