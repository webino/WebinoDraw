<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Cache;

use DOMNode;
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
     * @var object[]
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

            $cachedNode = $node->ownerDocument->getXpath()->query('//*[@__cacheKey="' . $cacheKey . '"]')->item(0);

            if (empty($cachedNode)) {
                // TODO logger should be saved to cache
                //echo 'SHOULD SAVE: ' . print_r($spec['locator'], true);echo  '<br />';
                continue;
            }


            $cachedNode->removeAttribute('__cacheKey');
            $xhtml = $cachedNode->ownerDocument->saveXML($cachedNode);
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
     * @param DrawEvent $event
     * @return bool true = loaded
     */
    public function load(DrawEvent $event)
    {
        $spec = $event->getSpec();
        if (empty($spec['cache'])) {
            return false;
        }

        foreach ($event->getNodes()->toArray() as $node) {
            $cacheKey = $this->createCacheKey($node, $event);
            $xhtml = $this->cache->getItem($cacheKey);
            if (empty($xhtml)) {
                // TODO logger queued to cache
                //echo 'CANNOT LOAD: ' . print_r($spec['locator'], true);echo  '<br />';
                $this->nodes[$cacheKey] = $node;
                $node->setAttribute('__cacheKey', $cacheKey);
                $node->setOnReplace(function ($newNode) use ($cacheKey) {
                    $newNode->setAttribute('__cacheKey', $cacheKey);
                });
                return false;
            }

            // TODO logger loading cached
            //echo '<br />LOAD: ' . print_r($spec['cache'], true) . '<br />' . htmlspecialchars($xhtml) . '<br />';
            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($xhtml);
            $node->parentNode->replaceChild($frag, $node);
        }

        return true;
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

            $helper->getVarTranslator()
                ->createTranslation($helper->getVars())
                ->getVarTranslation()
                ->translate($specCacheKey);

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
}
