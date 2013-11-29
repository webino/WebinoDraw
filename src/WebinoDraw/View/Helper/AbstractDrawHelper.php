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
use WebinoDraw\WebinoDraw;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Filter\FilterPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\Cache\StorageFactory as CacheStorage;
use Zend\Cache\Storage\StorageInterface as CacheStorageInterface;

/**
 *
 */
abstract class AbstractDrawHelper extends AbstractHelper implements
    DrawHelperInterface,
    EventManagerAwareInterface,
    ServiceLocatorAwareInterface
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
     * @var WebinoDraw
     */
    protected $draw;

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
     * @var FilterPluginManager
     */
    protected $filterPluginManager;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

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
                        'options' => array(
                            'namespace' => 'webinodraw',
                            'cacheDir'  => 'data/cache'
                        ),
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
     * @return WebinoDraw
     */
    public function getDraw()
    {
        if (null === $this->draw) {
            $this->setDraw($this->getServiceLocator()->getServiceLocator()->get('WebinoDraw'));
        }
        return $this->draw;
    }

    /**
     * @param WebinoDraw $draw
     * @return AbstractDrawHelper
     */
    public function setDraw(WebinoDraw $draw)
    {
        $this->draw = $draw;
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
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
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

        empty($spec['var']['default']) or
            $varTranslator->translationDefaults(
                $translation,
                $spec['var']['default']
            );

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

        empty($spec['var']['default']) or
            $varTranslator->translationDefaults(
                $translation,
                $spec['var']['default']
            );

        return $this;
    }

    /**
     * Expand spec instructions with instructions from the instructionset
     *
     * @todo PHP 5.4 protected
     *
     * @param array $spec
     * @return AbstractDrawHelper
     */
    public function expandInstructionsFromSet(array &$spec)
    {
        if (empty($spec['instructionset'])) {
            return $this;
        }

        $draw         = $this->getDraw();
        $instructions = $this->getInstructionsPrototype();

        foreach ($spec['instructionset'] as $instructionset) {
            $instructions->merge($draw->instructionsFromSet($instructionset));
        }

        unset($spec['instructionset']);

        foreach ($instructions->getSortedArrayCopy() as $instruction) {
            $spec['instructions'][key($instruction)] = current($instruction);
        }

        return $this;
    }

    /**
     * @todo PHP 5.4 protected
     *
     * @param NodeList $nodes
     * @param array $instructions
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    public function subInstructions(NodeList $nodes, array $instructions, ArrayAccess $translation)
    {
        foreach ($nodes as $node) {

            $this
                ->cloneInstructionsPrototype($instructions)
                ->render(
                   $node,
                   $this->view,
                   $translation->getArrayCopy()
               );
        }

        return $this;
    }

    /**
     * Returns array translation of the node
     *
     * @param Element $node
     * @return array
     */
    public function nodeTranslation(Element $node, array $spec = array())
    {
        $translation = clone $this->getTranslationPrototype();

        $translation->exchangeArray(
            $node->getProperties(self::EXTRA_VAR_PREFIX)
        );

        $htmlTranslation = $this->nodeHtmlTranslation($node, $spec);

        $translation->merge(
            $htmlTranslation->getArrayCopy()
        );

        return $translation;
    }

    public function nodeHtmlTranslation(Element $node, array $spec)
    {
        $translation  = clone $this->getTranslationPrototype();
        $innerHtmlKey = self::EXTRA_VAR_PREFIX . 'innerHtml';
        $outerHtmlKey = self::EXTRA_VAR_PREFIX . 'outerHtml';

        foreach (
            array(
                'html',
                'replace',
            ) as $key
        ) {
            if (empty($spec[$key])) {
                continue;
            }

            if (false !== strpos($spec[$key], $innerHtmlKey)) {
                // include node innerHTML to the translation
                $translation[$innerHtmlKey] = $node->getInnerHtml();
            }

            if (false !== strpos($spec[$key], $outerHtmlKey)) {
                // include node outerHTML to the translation
                $translation[$outerHtmlKey] = $node->getOuterHtml();
            }
        }

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

        if (!empty($spec['cache_key_trigger'])) {

            $events = $this->getEventManager();
            foreach ((array) $spec['cache_key_trigger'] as $eventName) {
                $results = $events->trigger($eventName, $this, array('spec' => $spec));
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
     * @return AbstractDrawHelper
     */
    protected function cacheSave(NodeList $nodes, array $spec)
    {
        if (empty($spec['cache'])) {
            return $this;
        }

        $cache = $this->getCache();

        foreach ($nodes as $node) {

            $key  = $this->resolveCacheKey($node, $spec);
            $html = $node->ownerDocument->saveXml($node);

            $cache->setItem($key, $html);
            $cache->setTags($key, (array) $spec['cache']);
        }

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
