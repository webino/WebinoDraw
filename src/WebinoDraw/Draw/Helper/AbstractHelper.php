<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
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
 * Class AbstractHelper
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
     * @var Translation
     */
    private $varTranslation;

    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        $this->setVarTranslation(null);
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @param VarTranslator $varTranslator
     * @return $this
     */
    public function setVarTranslator(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        return $this;
    }

    /**
     * @return VarTranslator
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
     * @param DrawEvent $event
     * @return $this
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
     * @return Translation ArrayAccess
     */
    public function getVarTranslation()
    {
        if ($this->varTranslation === null) {
            $this->setVarTranslation(
                $this->getVarTranslator()->createTranslation($this->getVars())->makeVarKeys()
            );
        }
        return $this->varTranslation;
    }

    /**
     * @param ArrayAccess|null $varTranslation
     * @return $this
     */
    public function setVarTranslation(ArrayAccess $varTranslation = null)
    {
        $this->varTranslation = $varTranslation;
        return $this;
    }

    /**
     * @param string|array $subject
     * @return mixed
     */
    public function translate(&$subject)
    {
        $this->getVarTranslation()->translate($subject);
        return $subject;
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
     * @return $this
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
     * @return $this
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
