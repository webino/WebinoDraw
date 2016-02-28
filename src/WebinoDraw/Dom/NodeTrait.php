<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2015-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

use WebinoDraw\Exception;

/**
 * Class NodeTrait
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
     * @return Document
     */
    public function getOwnerDocument()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->ownerDocument;
    }

    /**
     * @return Element
     */
    public function getParentNode()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->parentNode;
    }

    /**
     * @param string $html
     * @return NodeInterface
     * @throws Exception\LogicException
     */
    public function replaceWith($html)
    {
        $frag = $this->getOwnerDocument()->createDocumentFragment();
        $frag->appendXml($html);

        $newNode = $this->getParentNode()->insertBefore($frag, $this);

        if (!empty($this->onReplace)) {
            foreach ($this->onReplace as $onReplace) {
                call_user_func($onReplace, $newNode, $this, $frag);
            }
        }

        return $newNode;
    }
}
