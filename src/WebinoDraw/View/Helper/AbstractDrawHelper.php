<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use ArrayAccess;
use DOMElement;
use WebinoDraw\DrawEvent;
use WebinoDraw\Stdlib\DrawInstructions;
use WebinoDraw\Stdlib\DrawTranslation;
use WebinoDraw\Stdlib\VarTranslator;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Filter\FilterPluginManager;
use Zend\Filter\StaticFilter;
use Zend\View\Helper\AbstractHelper;

/**
 *
 */
abstract class AbstractDrawHelper extends AbstractHelper implements
    DrawHelperInterface,
    EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var string
     */
    protected $eventIdentifier;

    /**
     *
     * @var DrawEvent
     */
    protected $event;

    /**
     * @var FilterPluginManager
     */
    protected $filterPluginManager;

    /**
     * @var array
     */
    protected $vars = array();

    /**
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @var DrawTranslation
     */
    protected $translationPrototype;

    /**
     * @var DrawInstructions
     */
    protected $instructionsPrototype;

    /**
     * Get the attached event
     *
     * Will create a new Event if none provided.
     *
     * @return DrawEvent
     */
    public function getEvent()
    {
        if (null === $this->event) {
            $this->setEvent(new DrawEvent);
        }
        return $this->event;
    }

    /**
     * Set an event to use
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
     * @return AbstractDrawHelper
     */
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

    /**
     * @return FilterPluginManager
     */
    public function getFilterPluginManager()
    {
        if (null === $this->filterPluginManager) {
            $this->setFilterPluginManager(StaticFilter::getPluginManager());
        }

        return $this->filterPluginManager;
    }

    /**
     * @param FilterPluginManager $filterManager
     * @return AbstractDrawHelper
     */
    public function setFilterPluginManager(FilterPluginManager $filterManager)
    {
        $this->filterPluginManager = $filterManager;
        return $this;
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
     * @return AbstractDrawHelper
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @param  VarTranslator $varTranslator
     * @return AbstractDrawHelper
     */
    public function setVarTranslator(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        return $this;
    }

    /**
     * @return VarTranslators
     */
    public function getVarTranslator()
    {
        if (!$this->varTranslator) {
            $this->setVarTranslator(new VarTranslator);
        }
        return $this->varTranslator;
    }

    /**
     * @return DrawTranslation
     */
    public function getTranslationPrototype()
    {
        if (null === $this->translationPrototype) {
            $this->setTranslationPrototype(new DrawTranslation);
        }

        return $this->translationPrototype;
    }

    /**
     * @param DrawTranslation $translationPrototype
     * @return AbstractDrawHelper
     */
    public function setTranslationPrototype($translationPrototype)
    {
        $this->translationPrototype = $translationPrototype;
        return $this;
    }

    /**
     * @param array $input
     * @return DrawTranslation
     */
    public function cloneTranslationPrototype(array $input = null)
    {
        $translation = clone $this->getTranslationPrototype();
        $translation->exchangeArray($input);

        return $translation;
    }

    /**
     * @return DrawInstructions
     */
    public function getInstructionsPrototype()
    {
        if (null === $this->instructionsPrototype) {
            $this->setInstructionsPrototype(new DrawInstructions);
        }

        return $this->instructionsPrototype;
    }

    /**
     * @param DrawInstructions $instructionsPrototype
     * @return AbstractDrawHelper
     */
    public function setInstructionsPrototype(DrawInstructions $instructionsPrototype)
    {
        $this->instructionsPrototype = $instructionsPrototype;
        return $this;
    }

    /**
     * @param array $input
     * @return DrawInstructions
     */
    public function cloneInstructionsPrototype(array $input = null)
    {
        $instructions = clone $this->getInstructionsPrototype();
        $instructions->exchangeArray($input);

        return $instructions;
    }

    /**
     * Get array translation from DOM node.
     *
     * @param DOMElement $node
     * @return array
     */
    public function nodeTranslation(DOMElement $node)
    {
        $translation = clone $this->getTranslationPrototype();

        if (!empty($node->nodeValue)) {
            $translation['nodeValue'] = $node->nodeValue;
        }

        foreach ($node->attributes as $attr) {
            $translation[$attr->name] = $attr->value;
        }

        return $translation;
    }

    /**
     * Apply varTranslator on translation.
     *
     * @param ArrayAccess $translation
     * @param array $spec
     * @return AbstractDrawHelper
     */
    public function applyVarTranslator(ArrayAccess $translation, array $spec)
    {
        $varTranslator = $this->getVarTranslator();

        empty($spec['var']['filter']['pre']) or
            $varTranslator->applyFilter(
                $translation,
                $spec['var']['filter']['pre'],
                $this->getFilterPluginManager()
            );

        empty($spec['var']['helper']) or
            $varTranslator->applyHelper(
                $translation,
                $spec['var']['helper'],
                $this->view->getHelperPluginManager()
            );

        empty($spec['var']['filter']['post']) or
            $varTranslator->applyFilter(
                $translation,
                $spec['var']['filter']['post'],
                $this->getFilterPluginManager()
            );

        return $this;
    }

    /**
     * @param array $triggers
     * @return AbstractDrawHelper
     */
    protected function trigger(array $triggers)
    {
        $event  = $this->getEvent();
        $events = $this->getEventManager();

        foreach ($triggers as $eventName) {
            $events->trigger($eventName, $event);
        }

        return $this;
    }
}
