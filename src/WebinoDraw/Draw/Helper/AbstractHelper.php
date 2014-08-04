<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper;

use ArrayAccess;
use WebinoDraw\Cache\DrawCache;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Event\DrawEvent;
use WebinoDraw\Exception;
use WebinoDraw\Manipulator\Manipulator;
use WebinoDraw\VarTranslator\Translation;
use WebinoDraw\VarTranslator\VarTranslator;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

/**
 *
 */
abstract class AbstractHelper implements
    HelperInterface,
    EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * @var string
     */
    protected $eventIdentifier = 'WebinoDraw';

    /**
     * @var DrawCache
     */
    private $cache;

    /**
     * @var DrawEvent
     */
    private $event;

    /**
     * @var Manipulator
     */
    private $manipulator;

    /**
     * @var array
     */
    private $vars = [];

    /**
     * @var VarTranslator
     */
    private $varTranslator;

    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        $this->drawNodes($nodes, $spec);
    }

    /**
     * @return DrawCache
     */
    public function getCache()
    {
        if (null === $this->cache) {
            throw new Exception\RuntimeException('Expected injected DrawCache');
        }
        return $this->cache;
    }

    /**
     * @param DrawCache $cache
     * @return self
     */
    public function setCache(DrawCache $cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
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
     * @param DrawEvent $event
     */
    public function setEvent(DrawEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return Manipulator
     * @throws Exception\RuntimeException
     */
    public function getManipulator()
    {
        if (null === $this->manipulator) {
            throw new Exception\RuntimeException('Expected injected Manipulator');
        }
        return $this->manipulator;
    }

    /**
     * @param Manipulator $manipulator
     * @return self
     */
    public function setManipulator(Manipulator $manipulator)
    {
        $this->manipulator = $manipulator;
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
     * @param array $vars
     * @return self
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @param VarTranslator $varTranslator
     * @return self
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
        if (null === $this->varTranslator) {
            throw new Exception\RuntimeException('Expected injected VarTranslator');
        }
        return $this->varTranslator;
    }

    /**
     * @param array $triggers
     * @param DrawEvent
     * @return self
     */
    protected function trigger(array $triggers, DrawEvent $event)
    {
        $events = $this->getEventManager();
        foreach ($triggers as $eventName) {
            $events->trigger($eventName, $event);
        }

        return $this;
    }

    /**
     * @param string $value
     * @param Translation $varTranslation
     * @param array $spec
     * @return string
     */
    public function translateValue($value, Translation $varTranslation, array $spec)
    {
        return $varTranslation->translateString($value);
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return self
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $this->manipulateNodes($nodes, $spec, $this->getVarTranslator()->createTranslation($this->getVars()));
        return $this;
    }

    /**
     * Manipulate nodes
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return self
     */
    public function manipulateNodes(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        $this->getManipulator()->manipulate([
            'helper'      => $this,
            'nodes'       => $nodes,
            'spec'        => $spec,
            'translation' => $translation,
        ]);
        return $this;
    }
}
