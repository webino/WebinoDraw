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
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\View\ViewEvent;

/**
 * Draw matched containers and return the JSON XHTML of matched fragments
 */
abstract class AbstractDrawAjaxStrategy extends AbstractDrawStrategy implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * @var AjaxEvent
     */
    protected $event;

    /**
     * @var string
     */
    protected $eventIdentifier = 'WebinoDraw';

    /**
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
     * @param AjaxEvent $event
     */
    public function setEvent(AjaxEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Return XHTML of nodes matched by XPath
     *
     * @param Document $dom
     * @param string $xpath
     * @return string XHTML
     */
    public function createContainer(Document $dom, $xpath)
    {
        $code = '';
        foreach ($dom->getXpath()->query($xpath) as $node) {
            if (!empty($node)) {
                $code.= $dom->saveHTML($node);
            }
        }

        return $code;
    }

    /**
     * @param ViewEvent $event
     */
    public function injectResponse(ViewEvent $event)
    {
        if (!$this->shouldRespond($event)) {
            return;
        }

        $response = $event->getResponse();
        $options  = $this->draw->getOptions();

        $dom = $this->draw->createDom(
            $this->createContainer(
                $this->draw->createDom($response->getBody()),
                $options->getAjaxContainerXpath()
            )
        );

        $this->draw->drawDom(
            $dom->documentElement,
            $options->getInstructions(),
            $this->collectModelVariables($event->getModel())
        );

        $response->setContent($this->respond($dom, $options->getAjaxFragmentXpath()));
    }

    /**
     * @param Document $dom
     * @param string $xpath
     * @return \WebinoDraw\Ajax\Json
     */
    abstract protected function respond(Document $dom, $xpath);
}
