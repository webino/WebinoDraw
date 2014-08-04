<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

use ArrayObject;
use DOMNodeList;
use IteratorAggregate;
use IteratorIterator;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Exception\RuntimeException;
use Zend\View\Helper\EscapeHtml;

/**
 * Batch DOMElement manipulation
 */
class NodeList implements IteratorAggregate
{
    /**
     * @var IteratorIterator
     */
    protected $nodes;

    /**
     * @var EscapeHtml
     */
    protected $escapeHtml;

    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @param array|DOMNodeList $nodes DOMNodes in array or DOMNodelist
     */
    public function __construct(Locator $locator, $nodes = null)
    {
        $this->locator = $locator;
        empty($nodes) or
            $this->setNodes($nodes);
    }

    /**
     * @param array|DOMNodeList $nodes DOMNodes in array or DOMNodelist
     * @return NodeList
     */
    public function create($nodes)
    {
        return new self($this->locator, $nodes);
    }

    /**
     * @return IteratorIterator
     */
    public function getNodes()
    {
        if (null === $this->nodes) {
            $this->setNodes([]);
        }
        return $this->nodes;
    }

    /**
     * @param array|DOMNodeList|IteratorIterator $nodes
     * @return NodeList
     * @throws InvalidArgumentException
     */
    public function setNodes($nodes)
    {
        if ($nodes instanceof IteratorIterator) {
            $this->nodes = $nodes;
            return $this;
        }
        if (is_array($nodes)) {
            $this->nodes = new IteratorIterator(new ArrayObject($nodes));
            return $this;
        }
        if ($nodes instanceof DOMNodeList) {
            $this->nodes = new IteratorIterator($nodes);
            return $this;
        }

        throw new InvalidArgumentException('Expected nodes as array|DOMNodelist');
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->getNodes()->getInnerIterator();
    }

    /**
     * @return EscapeHtml
     */
    public function getEscapeHtml()
    {
        if (null === $this->escapeHtml) {
            $this->setEscapeHtml(new EscapeHtml);
        }
        return $this->escapeHtml;
    }

    /**
     * @param EscapeHtml $escapeHtml
     */
    public function setEscapeHtml(EscapeHtml $escapeHtml)
    {
        $this->escapeHtml = $escapeHtml;
        return $this;
    }

    /**
     * Set nodes text value
     *
     * @param string $value
     * @param Callable $preSet Modify and return value, passed parameters $node, $value
     * @return NodeList
     */
    public function setValue($value, $preSet = null)
    {
        $escapeHtml = $this->getEscapeHtml();
        foreach ($this as $node) {
            $nodeValue       = is_callable($preSet) ? $preSet($node, $value, $this) : $value;
            $node->nodeValue = $escapeHtml($nodeValue);
        }

        return $this;
    }

    /**
     * Set nodes html value
     *
     * @param string $xhtml
     * @param Callable $preSet Modify and return xhtml, passed parameters $node, $xhtml
     * @return NodeList
     */
    public function setHtml($xhtml, $preSet = null)
    {
        foreach ($this as $node) {
            $nodeXhtml = is_callable($preSet) ? $preSet($node, $xhtml, $this) : $xhtml;
            $node->nodeValue = '';

            if (empty($nodeXhtml)) {
                continue;
            }

            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($nodeXhtml);
            $node->appendChild($frag);
        }

        return $this;
    }

    /**
     * Append XHTML to nodes
     *
     * @param string $xhtml Valid XHTML
     * @return NodeList Newly created nodes
     */
    public function appendHtml($xhtml)
    {
        $nodes     = [];
        $childNode = null;

        foreach ($this as $node) {
            if (empty($childNode)) {
                $childNode = $node->ownerDocument->createDocumentFragment();
                $childNode->appendXml($xhtml);
            }

            $nodes[] = $node->appendChild(clone $childNode);
        }

        return $this->create($nodes);
    }

    /**
     * Set nodes attributes
     *
     * @param array $attribs Attributes to set
     * @param Callable $preSet Modify and return value, assed parameters $node, $value
     * @return NodeList
     */
    public function setAttribs(array $attribs, $preSet = null)
    {
        foreach ($this as $node) {
            // prepare callback
            $callback = $preSet
                      ? function ($value) use ($node, $preSet) {
                            return $preSet($node, $value, $this);
                      }
                      : null;

            $node->setAttributes($attribs, $callback);
        }

        return $this;
    }

    /**
     * Replace node with XHTML code
     *
     * @param string $xhtml XHTML to replace node
     * @param Callable $preSet Modify and return xhtml, assed parameters $node, $xhtml
     * @return NodeList
     */
    public function replace($xhtml, $preSet = null)
    {
        $remove   = [];
        $nodeList = new ArrayObject;

        foreach ($this as $node) {
            $nodeXhtml = is_callable($preSet) ? $preSet($node, $xhtml, $this) : $xhtml;
            if (empty($nodeXhtml)) {
                $node->nodeValue = '';
                continue;
            }

            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($nodeXhtml);

            $nodeList[] = $node->parentNode->insertBefore($frag, $node);
            $remove[]   = $node;
        }

        foreach ($remove as $node) {
            $node->parentNode->removeChild($node);
        }

        $this->nodes = new IteratorIterator($nodeList);
        return $this;
    }

    /**
     * Remove target nodes
     *
     * @param string $locator CSS selector or XPath (xpath=)
     * @return NodeList
     */
    public function remove($locator = 'xpath=.')
    {
        if (empty($locator)) {
            return $this;
        }

        $remove = [];
        $this->each(
            $locator,
            function (NodeList $nodes) use (&$remove) {
                $remove = array_merge(
                    $remove,
                    $nodes->getNodes()->getArrayCopy()
                );
            }
        );

        foreach ($remove as $node) {
            empty($node->parentNode) or
                $node->parentNode->removeChild($node);
        }

        return $this;
    }

    /**
     * Perform callback on each node that match the locator
     *
     * @param string $locator
     * @param Callable $callback The NodeList parameter is passed
     * @return NodeList
     * @throws RuntimeException
     */
    public function each($locator, $callback)
    {
        if (empty($locator)) {
            return $this;
        }

        $xpath = $this->locator->set($locator)->xpathMatchAny();
        foreach ($this as $node) {
            if (!($node->ownerDocument instanceof Document)) {
                throw new RuntimeException('Expects Dom\Document with xpath');
            }

            $nodes = $node->ownerDocument->getXpath()->query($xpath, $node);
            foreach ($nodes as $subnode) {
                $callback($this->create([$subnode]));
            }
        }

        return $this;
    }
}
