<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Helper;

use ArrayAccess;
use DOMNode;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\DrawEvent;
use WebinoDraw\Instructions\Instructions;
use WebinoDraw\Manipulator\Manipulator;
use WebinoDraw\Stdlib\Translation;
use WebinoDraw\Stdlib\VarTranslator;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Cache\StorageFactory as CacheStorage;
use Zend\Cache\Storage\StorageInterface as CacheStorageInterface;

/**
 *
 */
abstract class AbstractDrawHelper implements
    DrawHelperInterface,
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
     * @return CacheStorageInterface
     */
    public function getCache()
    {
        if (empty($this->cache)) {
            $this->setCache(
                CacheStorage::factory(
                    [
                        'adapter' => 'filesystem',
                        'options' => [
                            'namespace' => 'webinodraw',
                            'cacheDir'  => 'data/cache'
                        ],
                    ]
                )
            );
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
     * @return self
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers([
            'WebinoDraw\Helper\DrawHelperInterface',
            __CLASS__,
            get_called_class(),
            $this->eventIdentifier,
            'WebinoDraw'
        ]);

        $this->eventManager = $eventManager;
        return $this;
    }

    public function getManipulator()
    {
        return $this->manipulator;
    }

    public function setManipulator(Manipulator $manipulator)
    {
        $this->manipulator = $manipulator;
        return $this;
    }

    public function getSpec()
    {
        return $this->spec;
    }

    public function setSpec(array $spec)
    {
        $this->spec = $spec;
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
            throw new \RuntimeException('Expected injected VarTranslator');
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
     * @param array $node
     * @return string
     */
    protected function resolveCacheKey(DOMNode $node, array $spec)
    {
        $cacheKey = $node->getNodePath();

        if (!empty($spec['cache_key'])) {
            // replace vars in the cache key settings
            $varTranslator = $this->getVarTranslator();
            $varTranslator->translate(
                $spec['cache_key'],
                $this->cloneTranslationPrototype($this->getVars())->getVarTranslation()
            );

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
     * @param NodeList $nodes
     * @param array $spec
     * @return bool True = loaded
     */
    protected function cacheLoad(NodeList $nodes, array $spec)
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
     * @param NodeList $nodes
     * @param array $spec
     * @return self
     */
    protected function cacheSave(NodeList $nodes, array $spec)
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
     * @param NodeList $nodes
     * @param array $spec
     * @return void
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        $this->drawNodes($nodes, $spec);
    }

    public function translateValue($value, ArrayAccess $varTranslation)
    {
        return $this->getVarTranslator()->translateString($value, $varTranslation);
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return AbstractDrawElement
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        // TODO
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
