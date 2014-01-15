<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Dom\NodeList;
use WebinoDraw\Stdlib\ArrayFetchInterface;

/**
 * Draw helper used for DOMElement modifications.
 */
class DrawElement extends AbstractDrawElement
{
    /**
     * @var string
     */
    protected $eventIdentifier = __CLASS__;

    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        if (empty($spec['loop'])
            && $this->cacheLoad($nodes, $spec)
        ) {
            return;
        }

        $event = $this->getEvent();

        $event->clearSpec()
            ->setHelper($this)
            ->setSpec($spec)
            ->setNodes($nodes);

        !array_key_exists('trigger', $spec) or
            $this->trigger($spec['trigger']);

        $this->drawNodes($nodes, $event->getSpec()->getArrayCopy());

        !empty($spec['loop']) or
            $this->cacheSave($nodes, $spec);
    }

    /**
     * Cached loop
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayFetchInterface $translation
     * @return DrawElement
     */
    protected function loop(NodeList $nodes, array $spec, ArrayFetchInterface $translation)
    {
        foreach ($nodes as $node) {

            $parentNodes = $nodes->createNodeList(array($node->parentNode));
            if ($this->cacheLoad($parentNodes, $spec)) {
                continue;
            }

            parent::loop($nodes->createNodeList(array($node)), $spec, $translation);
            $this->cacheSave($parentNodes, $spec);
        }

        return $this;
    }
}
