<?php

namespace WebinoDraw\Dom;

use WebinoDraw\Exception;

/**
 * Class NodeTrait
 * @TODO redesign
 */
trait NodeTrait
{
    /**
     * @return self|null
     */
    abstract public function getCachedNode();

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return $this->getAttribute($this::CACHE_KEY_ATTR);
    }

    /**
     * @param NodeInterface|null $node
     * @return bool
     */
    protected function validCachedNode(NodeInterface $node = null)
    {
        return !empty($node->ownerDocument) && $node->hasAttribute($this::CACHE_KEY_ATTR);
    }

    /**
     * @return NodeInterface
     */
    public function resolveNewNode()
    {
        $cachedNode = $this->getCachedNode();
        if (!$cachedNode->hasAttribute('__newNodeId')) {
            return $this;
        }

        $newNodeId = $cachedNode->getAttribute('__newNodeId');
        $newNode   = $this->ownerDocument->getXpath()->query('//*[@__nodeId="' . $newNodeId . '"]')->item(0);

        if (null === $newNode) {
            // node not available
            return null;
        }

        $newNode->removeAttribute('__nodeId');
        return $newNode;
    }
}
