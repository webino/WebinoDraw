<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Strategy;

use WebinoDraw\Dom\Document;
use WebinoDraw\Event\AjaxEvent;
use WebinoDraw\Exception;

/**
 * Draw matched containers and return the JSON XHTML of matched fragments
 */
class DrawAjaxHtmlStrategy extends AbstractDrawAjaxStrategy
{
    /**
     * Return XHTML parts of nodes matched by XPath
     *
     * @param Document $dom
     * @param string $xpath
     * @return array
     * @throws Exception\RuntimeException
     */
    public function createMarkup(Document $dom, $xpath)
    {
        $markup = '';
        foreach ($dom->getXpath()->query($xpath) as $item) {

            $itemId = $item->getAttribute('id');
            if (empty($itemId)) {
                throw new Exception\RuntimeException('Required ajax fragment element id');
            }

            $markup.= $dom->saveHTML($item);
        }

        return $markup;
    }

    /**
     * @param Document $dom
     * @param string $xpath
     * @return string
     */
    protected function respond(Document $dom, $xpath)
    {
        $ajaxEvent = $this->getEvent();
        $ajaxEvent->setFragmentXpath($xpath);
        $this->getEventManager()->trigger(AjaxEvent::EVENT_AJAX, $ajaxEvent);
        return $this->createMarkup($dom, $ajaxEvent->getFragmentXpath());
    }
}
