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
use DOMNode;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\DrawEvent;
use WebinoDraw\Stdlib\DrawInstructions;
use WebinoDraw\Stdlib\Translation;
use WebinoDraw\Stdlib\VarTranslator;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Filter\FilterPluginManager;
use Zend\View\Helper\AbstractHelper;
use Zend\Cache\StorageFactory as CacheStorage;
use Zend\Cache\Storage\StorageInterface as CacheStorageInterface;

/**
 *
 */
abstract class AbstractDrawHelper extends AbstractHelper implements
    DrawHelperInterface,
    EventManagerAwareInterface
{
    /**
     * Prefix of the extra variables to avoid conflicts
     */
    const EXTRA_VAR_PREFIX = '_';

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
     * @var Translation
     */
    protected $translationPrototype;

    /**
     * @var DrawInstructions
     */
    protected $instructionsPrototype;

    /**
     * @return CacheStorageInterface
     */
    public function getCache()
    {
        if (empty($this->cache)) {
            $this->setCache(
                CacheStorage::factory(
                    array(
                        'adapter' => 'filesystem',
                        'options' => array('data/cache'),
                    )
                )
            );
        }

        return $this->cache;
    }

    /**
     * @param CacheStorageInterface $cache
     * @return AbstractDrawHelper
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
            throw new \RuntimeException('Expected filter plugin manager');
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
     * @param array $vars
     * @return AbstractDrawHelper
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @param VarTranslator $varTranslator
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
     * @return AbstractDrawHelper
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
     * Apply varTranslator on translation
     *
     * @param ArrayAccess $translation
     * @param array $spec
     * @return AbstractDrawHelper
     */
    public function applyVarTranslator(ArrayAccess $translation, array $spec)
    {
        $varTranslator = $this->getVarTranslator();

        empty($spec['var']['set']) or
            $varTranslator->translationMerge(
                $translation,
                $spec['var']['set']
            );

        empty($spec['var']['fetch']) or
            $varTranslator->translationFetch(
                $translation,
                $spec['var']['fetch']
            );

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
     * Returns array translation of the node
     *
     * @param Element $node
     * @return array
     */
    public function nodeTranslation(Element $node)
    {
        $translation = clone $this->getTranslationPrototype();

        $translation->exchangeArray(
            $node->getProperties(self::EXTRA_VAR_PREFIX)
        );

        return $translation;
    }

    /**
     * Return the cache key
     *
     * @param array $node
     * @return string
     */
    protected function cacheKey(DOMNode $node)
    {
        return md5($node->getNodePath());
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

            $html = $cache->getItem($this->cacheKey($node));

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
     * @return AbstractDrawHelper
     */
    protected function cacheSave(NodeList $nodes, array $spec)
    {
        if (empty($spec['cache'])) {
            return $this;
        }

        $cache = $this->getCache();

        foreach ($nodes as $node) {

            $key  = $this->cacheKey($node);
            $html = $node->ownerDocument->saveXml($node);

            $cache->setItem($key, $html);
            $cache->setTags($key, (array) $spec['cache']);
        }

        return $this;
    }

    /**
     * Return translated $spec by values in $translation
     *
     * @param array $spec
     * @param ArrayAccess $translation
     * @return array
     */
    protected function translateSpec(array $spec, ArrayAccess $translation)
    {
        $this->applyVarTranslator($translation, $spec);

        $varTranslator = $this->getVarTranslator();
        $varTranslator->translate(
            $spec,
            $varTranslator->makeVarKeys($translation)
        );

        return $spec;
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

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return void
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        $this->drawNodes($nodes, $spec);
    }
}
