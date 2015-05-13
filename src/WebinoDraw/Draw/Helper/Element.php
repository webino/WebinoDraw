<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper;

use WebinoDraw\Dom\NodeList;

/**
 * Draw helper used for DOMElement modifications.
 */
class Element extends AbstractHelper
{
    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        $event = $this->getEvent();
        $event
            ->setHelper($this)
            ->clearSpec()
            ->setSpec($spec)
            ->setNodes($nodes);

        $cache = $this->getCache();
        $cacheEvent = clone $event;

        if (empty($spec['loop']) && $cache->load($cacheEvent)) {
            return;
        }

        array_key_exists('trigger', $spec)
            and $this->trigger($spec['trigger'], $event);

        $this->drawNodes($nodes, $event->getSpec()->getArrayCopy());

        empty($spec['loop'])
            and $cache->save($cacheEvent);

    }
}
