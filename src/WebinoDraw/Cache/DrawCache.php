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
 *
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

        foreach ($event->getNodes() as $node) {
            if (empty($node->ownerDocument)) {
                // node no longer exists
                continue;
            }

            $key   = $this->createCacheKey($node, $event);
            $xhtml = $node->ownerDocument->saveXml($node);

            $this->cache->setItem($key, $xhtml);
            $this->cache->setTags($key, (array) $spec['cache']);
        }

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

        foreach ($event->getNodes() as $node) {
            $xhtml = $this->cache->getItem($this->createCacheKey($node, $event));
            if (empty($xhtml)) {
                return false;
            }

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
