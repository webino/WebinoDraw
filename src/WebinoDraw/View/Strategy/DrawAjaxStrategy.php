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
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\View\ViewEvent;

/**
 * Draw matched containers and return the JSON XHTML of matched fragments
 */
class DrawAjaxStrategy extends AbstractDrawStrategy implements
    EventManagerAwareInterface
{
    /**
     * @var AjaxEvent
     */
    protected $event;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * Get the attached event
     *
     * Will create a new Event if none provided.
     *
     * @return AjaxEvent
     */
    public function getEvent()
    {
        if (null === $this->event) {
            $this->setEvent(new AjaxEvent);
        }
        return $this->event;
    }

    /**
     * Set an event to use during dispatch
     *
     * @param AjaxEvent $event
     * @return void
     */
    public function setEvent(AjaxEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager);
        }
        return $this->eventManager;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @return DrawAjaxStrategy
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(
            array(__CLASS__, 'WebinoDraw')
        );

        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * Return XHTML of nodes matched by XPath
     *
     * @param DOMDocument $dom
     * @param string $xpath
     * @return string XHTML
     */
    public function createContainer(DOMDocument $dom, $xpath)
    {
        $code = '';

        foreach ($dom->xpath->query($xpath) as $node) {

            if (empty($node)) {
                continue;
            }

            $code.= $dom->saveHTML($node);
        }

        return $code;
    }

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
     * @param ViewEvent $event
     * @return bool Exit
     */
    public function injectResponse(ViewEvent $event)
    {
        if (!$this->shouldRespond($event)) {
            return;
        }

        $response = $event->getResponse();
        $options  = $this->service->getOptions();

        $dom = $this->service->createDom(
            $this->createContainer(
                $this->service->createDom($response->getBody()),
                $options->getAjaxContainerXpath()
            )
        );

        $this->service->drawDom(
            $dom->documentElement,
            $options->getInstructions(),
            $this->collectModelVariables($event->getModel())
        );

        $response->setContent(
            $this->respond($dom, $options->getAjaxFragmentXpath())
                ->jsonSerialize()
        );
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
            );
    }
}
