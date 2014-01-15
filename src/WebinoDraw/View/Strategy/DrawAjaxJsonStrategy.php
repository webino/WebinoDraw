<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Strategy;

use DOMDocument;
use WebinoDraw\AjaxEvent;

/**
 * Draw matched containers and return the JSON XHTML of matched fragments
 */
class DrawAjaxJsonStrategy extends AbstractDrawAjaxStrategy
{

    /**
     * Return XHTML parts of nodes matched by XPath
     *
     * @param DOMDocument $dom
     * @param string $xpath
     * @return array
     * @throws Exception
     */
    public function createFragments(DOMDocument $dom, $xpath)
    {
        $data = array();

        foreach ($dom->xpath->query($xpath) as $item) {

            $itemId = $item->getAttribute('id');

            if (empty($itemId)) {
                throw new \RuntimeException('Required ajax fragment element id');
            }

            $data['fragment']['#' . $itemId] = $dom->saveHTML($item);
        }

        return $data;
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

        return $ajaxEvent->getJson()
            ->merge(
                $this->createFragments(
                    $dom,
                    $ajaxEvent->getFragmentXpath()
                )
            )
            ->jsonSerialize();
    }
}
