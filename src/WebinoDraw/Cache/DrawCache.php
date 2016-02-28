<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Cache;

use ArrayObject;
use DOMNode;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\Text;
use WebinoDraw\Event\DrawEvent;
use Zend\Cache\Storage\StorageInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

/**
 * Class DrawCache
 */
class DrawCache implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * Cache storage service name
     */
    const STORAGE = 'WebinoDrawCache';

    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @var string
     */
    protected $eventIdentifier = 'WebinoDraw';

    /**
     * @var Element[]|Text[]
     */
    private $nodes;

    /**
     * @param StorageInterface|object $cache
     */
    public function __construct(StorageInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Save nodes XHTML to the cache
     *
     * @todo refactor
     * @param DrawEvent $event
     * @return self
     */
    public function save(DrawEvent $event)
    {
        $spec = $event->getSpec();
        if (empty($spec['cache'])) {
            return $this;
        }

        foreach ($this->nodes as $cacheKey => $node) {
            if (empty($node->ownerDocument)) {
                continue;
            }

            $doc = $node->getOwnerDocument();
            $cachedNode = $doc->getXpath()->query('//*[@__cacheKey="' . $cacheKey . '"]')->item(0);

            if (empty($cachedNode) || !($cachedNode instanceof Element)) {
                // TODO logger should be saved to cache
                //echo 'SHOULD SAVE: ' . print_r($spec['locator'], true);echo  '<br />';
                continue;
            }

            $cachedNode->removeAttribute('__cacheKey');

            // TODO redesign
            if ($node instanceof Text || 'text' === $cachedNode->getAttribute('__cache')) {
                $cachedNode->removeAttribute('__cache');
                $xhtml = $doc->saveXML($cachedNode->firstChild);
            } else {
                $xhtml = $doc->saveXML($cachedNode);
            }

            // TODO logger saving to cache
            //echo '<br />SAVE: ' . print_r($spec['cache'], true) . '<br />' . htmlspecialchars($xhtml) . '<br />';
            $this->cache->setItem($cacheKey, $xhtml);
            $this->cache->setTags($cacheKey, (array) $spec['cache']);
        }

        $this->nodes = [];
        return $this;
    }

    /**
     * Load nodes XHTML from the cache
     *
     * @todo refactor
     * @param DrawEvent $event
     * @return bool true = loaded
     */
    public function load(DrawEvent $event)
    {
        $spec = $event->getSpec();
        if (empty($spec['cache'])) {
            return false;
        }

        $cached = true;
        foreach ($event->getNodes()->toArray() as $_node) {
            $node     = $this->nodeToCache($spec, $_node);
            $cacheKey = $this->createCacheKey($node, $event);
            $xhtml    = $this->cache->getItem($cacheKey);

            if (empty($xhtml)) {
                $cached = false;
                // TODO logger queued to cache
                //echo 'CANNOT LOAD: ' . print_r($spec['locator'], true);echo  '<br />';
                $this->nodes[$cacheKey] = $node;

                if ($node instanceof Text) {
                    $node->getParentNode()->setAttribute('__cacheKey', $cacheKey);
                    $onReplace = function ($newNode) use ($cacheKey) {
                        $newNode->parentNode->setAttribute('__cacheKey', $cacheKey);
                    };

                } elseif ($node instanceof Element) {
                    $node->setAttribute('__cacheKey', $cacheKey);
                    $onReplace = function (Element $newNode) use ($cacheKey) {
                        $newNode->setAttribute('__cacheKey', $cacheKey);
                    };
                }

                if (isset($onReplace)) {
                    $node->setOnReplace($this->createOnReplaceHandler());
                    $node->setOnReplace($onReplace);
                }
                continue;
            }

            // TODO logger loading cached
            //echo '<br />LOAD: ' . print_r($spec['cache'], true) . '<br />' . htmlspecialchars($xhtml) . '<br />';
            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($xhtml);
            $node->parentNode->replaceChild($frag, $node);
        }

        return $cached;
    }

    /**
     * Select node to cache
     *
     * @param ArrayObject $spec
     * @param Element|Text $node
     * @return DomNode
     */
    private function nodeToCache(ArrayObject $spec, $node)
    {
        if (isset($spec['cache_node_xpath'])) {
            // TODO cache node not found exception
            return $node->getOwnerDocument()->getXpath()->query($spec['cache_node_xpath'], $node)->item(0);
        }
        return $node;
    }

    /**
     * @param DOMNode $node
     * @param DrawEvent $event
     * @return string
     */
    protected function createCacheKey(DOMNode $node, DrawEvent $event)
    {
        $spec     = $event->getSpec();
        $cacheKey = $node->getNodePath();

        if (!empty($spec['cache_key'])) {
            // replace vars in the cache key settings
            $specCacheKey = $spec['cache_key'];
            $helper       = $event->getHelper();

            /** @var \WebinoDraw\VarTranslator\Translation $translation */
            $translation = clone $helper->getVarTranslator()->getTranslation();
            $translation->merge($helper->getVars());
            $translation->getVarTranslation()->translate($specCacheKey);

            $cacheKey .= join('', $specCacheKey);
        }

        empty($spec['cache_key_trigger'])
            or $cacheKey .= $this->cacheKeyTrigger((array) $spec['cache_key_trigger'], $event);

        return md5($cacheKey);
    }

    /**
     * @param array $triggers
     * @param DrawEvent $event
     * @return string
     */
    protected function cacheKeyTrigger(array $triggers, DrawEvent $event)
    {
        $spec     = $event->getSpec();
        $helper   = $event->getHelper();
        $cacheKey = '';

        foreach ($triggers as $eventName) {
            $results = $this->getEventManager()->trigger($eventName, $helper, ['spec' => $spec]);
            foreach ($results as $result) {
                $cacheKey .= $result;
            }
        }

        return $cacheKey;
    }

    /**
     * @return \Closure
     */
    private function createOnReplaceHandler()
    {
        return function ($newNode, $oldNode, $frag) {
            $self = ($oldNode instanceof Text) ? $oldNode->getParentNode() : $oldNode;
            if ($self->hasAttribute('__cacheKey')) {
                $cacheKey = $self->getAttributeNode('__cacheKey');

                if ($newNode instanceof Text) {
                    $newParentNode = $newNode->getParentNode();
                    $newParentNode->setAttributeNode($cacheKey);
                    $newParentNode->setAttribute('__cache', 'text');

                } elseif ($newNode instanceof Element) {
                    if ($frag->childNodes->length <= 1) {
                        // has wrapper
                        $newNode->setAttributeNode($cacheKey);
                    } else {
                        $newNode->parentNode->setAttributeNode($cacheKey);
                    }
                }
                $self->removeAttribute('__cacheKey');
            }
        };
    }
}
