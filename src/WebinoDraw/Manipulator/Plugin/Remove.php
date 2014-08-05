<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use DOMElement;
use DOMNodeList;
use WebinoDraw\Dom\Document;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Exception;

/**
 *
 */
class Remove implements InLoopPluginInterface
{
    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @param Locator $locator
     */
    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     *
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['remove'])) {
            return;
        }

        $node = $arg->getNode();
        if (!($node instanceof DOMElement)) {
            throw new Exception\LogicException('Expected node of type DOMElement');
        }
        if (!($node->ownerDocument instanceof Document)) {
            throw new Exception\LogicException('Expects node ownerDocument of type Dom\Document');
        }

        $nodeXpath = $node->ownerDocument->getXpath();
        foreach ((array) $spec['remove'] as $removeLocator) {
            $this->removeNodes($nodeXpath->query($this->locator->set($removeLocator)->xpathMatchAny(), $node));
        }
    }

    /**
     * @param DOMNodeList $nodes
     * @return self
     * @throws Exception\LogicException
     */
    protected function removeNodes(DOMNodeList $nodes)
    {
        foreach ($nodes as $node) {
            if (!($node instanceof DOMElement)) {
                throw new Exception\LogicException('Expected node of type DOMElement');
            }

            empty($node->parentNode) or
                $node->parentNode->removeChild($node);
        }

        return $this;
    }
}
