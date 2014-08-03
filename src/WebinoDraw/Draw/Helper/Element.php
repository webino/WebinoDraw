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

use WebinoDraw\Dom\NodeList;

/**
 * Draw helper used for DOMElement modifications.
 */
class Element extends AbstractHelper
{
    /**
     * @var string
     */
    protected $eventIdentifier = __CLASS__;

    /**
     * @param NodeList $nodes
     */
    public function __invoke(NodeList $nodes)
    {
        $spec = $this->getSpec();
        if (empty($spec['loop']) && $this->cacheLoad($nodes)) {
            return;
        }

        $event = $this->getEvent();

        $event->clearSpec()
            ->setHelper($this)
            ->setSpec($spec)
            ->setNodes($nodes);

        !array_key_exists('trigger', $spec) or
            $this->trigger($spec['trigger']);

        $this->setSpec($event->getSpec()->getArrayCopy());
        $this->drawNodes($nodes);

        !empty($spec['loop']) or
            $this->cacheSave($nodes);

    }
}
