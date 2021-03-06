<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

use ArrayObject;
use DOMNodeList;
use IteratorAggregate;
use IteratorIterator;
use WebinoDraw\Exception;
use WebinoDraw\View\Helper\EscapeHtmlTrait;

/**
 * Batch DOMElement manipulation
 */
class NodeList implements IteratorAggregate
{
    use EscapeHtmlTrait;

    /**
     * @var IteratorIterator
     */
    protected $nodes;

    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @param Locator $locator
     * @param array|DOMNodeList $nodes DOMNodes in array or DOMNodeList
     */
    public function __construct(Locator $locator, $nodes = null)
    {
        $this->locator = $locator;
        empty($nodes) or $this->setNodes($nodes);
    }

    /**
     * @param array|DOMNodeList $nodes DOMNodes in array or DOMNodeList
     * @return $this
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
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function setNodes($nodes)
    {
        if ($nodes instanceof IteratorIterator) {
            $this->nodes = $nodes;

        } elseif (is_array($nodes)) {
            $this->nodes = new IteratorIterator(new ArrayObject($nodes));

        } elseif ($nodes instanceof DOMNodeList) {
            $this->nodes = new IteratorIterator($nodes);

        } else {
            throw new Exception\InvalidArgumentException('Expected nodes as array|DOMNodelist');
        }

        foreach ($this->nodes as $node) {
            // inject locator to node
            $node instanceof Locator\LocatorAwareInterface
                and $node->setLocator($this->locator);
        }

        return $this;
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->getNodes()->getInnerIterator();
    }

    /**
     * Set nodes text value
     *
     * @param string $value
     * @param Callable $preSet Modify and return value, passed parameters $node, $value
     * @return $this
     */
    public function setValue($value, $preSet = null)
    {
        $escapeHtml = $this->getEscapeHtml();
        foreach ($this as $node) {
            $nodeValue = is_callable($preSet) ? $preSet($node, $value, $this) : $value;
            $node->nodeValue = $escapeHtml($nodeValue);
        }

        return $this;
    }

    /**
     * Set nodes html value
     *
     * @param string $xhtml
     * @param Callable $preSet Modify and return xhtml, passed parameters $node, $xhtml
     * @return $this
     */
    public function setHtml($xhtml, $preSet = null)
    {
        foreach ($this as $node) {
            $nodeXhtml = is_callable($preSet) ? $preSet($node, $xhtml, $this) : $xhtml;
            $node->nodeValue = '';

            if (empty($nodeXhtml) || !($node instanceof Element)) {
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
     * @return $this Newly created nodes
     */
    public function appendHtml($xhtml)
    {
        $nodes = [];
        $childNode = null;

        foreach ($this as $node) {
            if (!($node instanceof Element)) {
                continue;
            }

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
     * @return $this
     */
    public function setAttribs(array $attribs, $preSet = null)
    {
        foreach ($this as $node) {
            if (!($node instanceof Element)) {
                continue;
            }

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
     * @return $this
     */
    public function replace($xhtml, $preSet = null)
    {
        $remove   = [];
        $nodeList = new ArrayObject;

        foreach ($this as $node) {
            if (!($node instanceof Element)) {
                continue;
            }

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
     * @return $this
     */
    public function remove($locator = '.')
    {
        if (empty($locator)) {
            return $this;
        }

        $remove = [];
        $this->each(
            $locator,
            function (NodeList $nodes) use (&$remove) {
                $remove = array_merge($remove, (array) $nodes->getIterator());
            }
        );

        foreach ($remove as $node) {
            empty($node->parentNode)
                or $node->parentNode->removeChild($node);
        }

        return $this;
    }

    /**
     * Perform callback on each node that match the locator
     *
     * @param string $locator
     * @param Callable $callback The NodeList parameter is passed
     * @return $this
     * @throws Exception\RuntimeException
     */
    public function each($locator, $callback)
    {
        if (empty($locator)) {
            return $this;
        }

        $xpath = $this->locator->set($locator)->xpathMatchAny();
        foreach ($this as $node) {
            if (!($node->ownerDocument instanceof Document)) {
                throw new Exception\RuntimeException('Expects `' . Document::class . '` with xpath');
            }

            $nodes = $node->ownerDocument->getXpath()->query($xpath, $node);
            foreach ($nodes as $subNode) {
                $callback($this->create([$subNode]));
            }
        }

        return $this;
    }

    /**
     * Return nodes in array
     *
     * Error-free nodes
     * manipulation in a loop.
     *
     * @return array
     */
    public function toArray()
    {
        $return = [];
        foreach ($this as $node) {
            (null === $node) or $return[] = $node;
        }
        return $return;
    }
}
