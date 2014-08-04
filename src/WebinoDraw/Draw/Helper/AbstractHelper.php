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
use DOMNode;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Event\DrawEvent;
use WebinoDraw\Exception;
use WebinoDraw\Manipulator\Manipulator;
use WebinoDraw\VarTranslator\Translation;
use WebinoDraw\VarTranslator\VarTranslator;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Cache\Storage\StorageInterface as CacheStorageInterface;

/**
 *
 */
abstract class AbstractHelper implements
    HelperInterface,
    EventManagerAwareInterface
//    ServiceLocatorAwareInterface
{
    /**
     * @var CacheStorageInterface
     */
    protected $cache;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var string
     */
    protected $eventIdentifier;

    /**
     * @var DrawEvent
     */
    protected $event;

    /**
     *
     * @var Manipulator
     */
    protected $manipulator;

    /**
     * @var array
     */
    protected $spec = [];

    /**
     * @var array
     */
    protected $vars = [];

    /**
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @var Translation
     */
    protected $translationPrototype;

    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        $this->drawNodes($nodes, $spec);
    }

    /**
     * @return CacheStorageInterface
     */
    public function getCache()
    {
        if (null === $this->cache) {
            throw new Exception\RuntimeException('Expected injected Cache');
        }
        return $this->cache;
    }

    /**
     * @param CacheStorageInterface $cache
     * @return self
     */
    public function setCache(CacheStorageInterface $cache)
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
     * @return self
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers([
            'WebinoDraw\Helper\HelperInterface',
            __CLASS__,
            get_called_class(),
            $this->eventIdentifier,
            'WebinoDraw'
        ]);

        $this->eventManager = $eventManager;
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
     * @return Translation
     */
    public function getTranslationPrototype()
    {
        if (null === $this->translationPrototype) {
            $this->setTranslationPrototype(new Translation);
        }

        return $this->translationPrototype;
    }

    /**
     * @param Translation $translationPrototype
     * @return self
     */
    public function setTranslationPrototype($translationPrototype)
    {
        $this->translationPrototype = $translationPrototype;
        return $this;
    }

    /**
     * @param array $input
     * @return Translation
     */
    public function cloneTranslationPrototype(array $input = null)
    {
        $translation = clone $this->getTranslationPrototype();
        $translation->exchangeArray($input);

        return $translation;
    }

    /**
     * Return the cache key
     *
     * @todo decouple
     * @param array $node
     * @param array $spec
     * @return string
     */
    public function resolveCacheKey(DOMNode $node, array $spec)
    {
        $cacheKey = $node->getNodePath();
        if (!empty($spec['cache_key'])) {
            // replace vars in the cache key settings
            $this->cloneTranslationPrototype($this->getVars())->getVarTranslation()
                ->translate($spec['cache_key']);

            // add cache keys
            $cacheKey .= join('', $spec['cache_key']);
        }

        if (!empty($spec['cache_key_trigger'])) {
            $events = $this->getEventManager();
            foreach ((array) $spec['cache_key_trigger'] as $eventName) {
                $results = $events->trigger($eventName, $this, ['spec' => $spec]);
                foreach ($results as $result) {
                    $cacheKey .= $result;
                }
            }
        }

        return md5($cacheKey);
    }

    /**
     * Load nodes XHTML from the cache
     *
     * @todo decouple
     * @param NodeList $nodes
     * @param array $spec
     * @return bool true = loaded
     */
    public function cacheLoad(NodeList $nodes, array $spec)
    {
        if (empty($spec['cache'])) {
            return false;
        }

        $cache = $this->getCache();
        foreach ($nodes as $node) {

            $html = $cache->getItem($this->resolveCacheKey($node, $spec));
            if (empty($html)) {
                return false;
            }

            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($html);
            $node->parentNode->replaceChild($frag, $node);
        }

        return true;
    }

    /**
     * Save nodes XHTML to the cache
     *
     * @todo decouple
     * @param NodeList $nodes
     * @param array $spec
     * @return self
     */
    public function cacheSave(NodeList $nodes, array $spec)
    {
        if (empty($spec['cache'])) {
            return $this;
        }

        $cache = $this->getCache();
        foreach ($nodes as $node) {
            if (empty($node->ownerDocument)) {
                // node no longer exists
                continue;
            }

            $key  = $this->resolveCacheKey($node, $spec);
            $html = $node->ownerDocument->saveXml($node);

            $cache->setItem($key, $html);
            $cache->setTags($key, (array) $spec['cache']);
        }

        return $this;
    }

    /**
     * @param array $triggers
     * @return self
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

    /**
     * @param string $value
     * @param ArrayAccess $varTranslation
     * @param array $spec
     * @return string
     */
    public function translateValue($value, ArrayAccess $varTranslation, array $spec)
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
        $translation = $this->cloneTranslationPrototype($this->getVars());
        $this->manipulateNodes($nodes, $spec, $translation);
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
