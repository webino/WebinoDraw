<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 * @package     WebinoDraw\View
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\DrawEvent;
use WebinoDraw\Stdlib\VarTranslator;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventsCapableInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * @category    Webino
 * @package     WebinoDraw\View
 * @subpackage  Helper
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
abstract class AbstractDrawHelper extends AbstractHelper implements
    DrawHelperInterface,
    EventsCapableInterface,
    EventManagerAwareInterface
{

    protected $eventManager;

    /**
     * @var string
     */
    protected $eventIdentifier;

    protected $event;

    /**
     * @var array
     */
    private $vars = array();

    /**
     * @var WebinoDraw\View\Helper\VarTranslator
     */
    private $varTranslator;

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            'WebinoDraw\View\Helper\DrawHelperInterface',
            __CLASS__,
            get_called_class(),
            $this->eventIdentifier,
            'WebinoDraw'
        ));

        $this->eventManager = $eventManager;
        return $this;
    }

    public function getEventManager()
    {
        if (empty($this->eventManager)) {
            $this->setEventManager(new EventManager);
        }
        return $this->eventManager;
    }


    /**
     * Set an event to use during dispatch
     *
     * By default, will re-cast to MvcEvent if another event type is provided.
     *
     * @param  DrawEvent $event
     * @return void
     */
    public function setEvent(DrawEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Get the attached event
     *
     * Will create a new Event if none provided.
     *
     * @return Event
     */
    public function getEvent()
    {
        if (empty($this->event)) {
            $this->setEvent(new DrawEvent);
        }
        return $this->event;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param  array $vars
     * @return \WebinoDraw\View\Helper\AbstractDrawHelper
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @param  \WebinoDraw\Stdlib\VarTranslator $varTranslator
     * @return \WebinoDraw\View\Helper\AbstractDrawHelper
     */
    public function setVarTranslator(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        return $this;
    }

    /**
     * @return WebinoDraw\Stdlib\VarTranslator
     */
    public function getVarTranslator()
    {
        if (!$this->varTranslator) {
            $this->setVarTranslator(new VarTranslator);
        }
        return $this->varTranslator;
    }

    /**
     * Get array translation from DOM node.
     *
     * @param  \DOMElement $node
     * @return array
     */
    public function nodeTranslation(\DOMElement $node)
    {
        $translation = array();

        if (!empty($node->nodeValue)) {
            $translation['nodeValue'] = $node->nodeValue;
        }

        foreach ($node->attributes as $attr) {
            $translation[$attr->name] = $attr->value;
        }

        return $translation;
    }
}
