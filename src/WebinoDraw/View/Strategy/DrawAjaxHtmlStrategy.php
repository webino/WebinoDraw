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

use DOMDocument;
use WebinoDraw\AjaxEvent;

/**
 * Draw matched containers and return the JSON XHTML of matched fragments
 */
class DrawAjaxHtmlStrategy extends AbstractDrawAjaxStrategy
{

    /**
     * Return XHTML parts of nodes matched by XPath
     *
     * @param DOMDocument $dom
     * @param string $xpath
     * @return array
     * @throws Exception
     */
    public function createMarkup(DOMDocument $dom, $xpath)
    {
        $markup = '';

        foreach ($dom->xpath->query($xpath) as $item) {

            $itemId = $item->getAttribute('id');

            if (empty($itemId)) {
                throw new \RuntimeException('Required ajax fragment element id');
            }

            $markup.= $dom->saveHTML($item);
        }

        return $markup;
    }

    /**
     * @param DOMDocument $dom
     * @param string $xpath
     * @return \WebinoDraw\Ajax\Json
     */
    protected function respond(DOMDocument $dom, $xpath)
    {
        $ajaxEvent = $this->getEvent();
        $ajaxEvent->setFragmentXpath($xpath);

        $this->getEventManager()->trigger(AjaxEvent::EVENT_AJAX, $ajaxEvent);

        return $this->createMarkup(
            $dom,
            $ajaxEvent->getFragmentXpath()
        );
    }
}
