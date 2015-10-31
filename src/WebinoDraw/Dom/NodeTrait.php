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
     * @var callable[]
     */
    private $onReplace = [];

    /**
     * @param callable $callback
     * @return $this
     */
    public function setOnReplace(callable $callback)
    {
        $this->onReplace[] = $callback;
        return $this;
    }

    /**
     * @param string $html
     * @return NodeInterface
     * @throws Exception\LogicException
     */
    public function replaceWith($html)
    {
        if (!($this->ownerDocument instanceof Document)) {
            throw new Exception\LogicException('Expects node ownerDocument of type ' . Document::class);
        }

        $frag = $this->ownerDocument->createDocumentFragment();
        $frag->appendXml($html);

        $newNode = $this->parentNode->insertBefore($frag, $this);

        // preserve cache key
        // TODO decouple to handler
        if ($this->hasAttribute('__cacheKey')) {
            $cacheKey = $this->getAttributeNode('__cacheKey');
            if ($newNode instanceof Text) {
                $newNode->parentNode->setAttributeNode($cacheKey);
                $newNode->parentNode->setAttribute('__cache', 'text');
            } else {
                $newNode->setAttributeNode($cacheKey);
            }
            $this->removeAttribute('__cacheKey');
        }

        if (!empty($this->onReplace)) {
            foreach ($this->onReplace as $onReplace) {
                call_user_func($onReplace, $this, $newNode);
            }
        }

        return $newNode;
    }
}
