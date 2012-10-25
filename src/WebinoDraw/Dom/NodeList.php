<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Dom
 */

namespace WebinoDraw\Dom;

use WebinoDraw\Exception;
use Zend\Dom\Css2Xpath;
use Zend\View\Helper\EscapeHtml;

/**
 * Batch DOMElement manipulation.
 *
 * @category    Webino
 * @package     WebinoDraw_Dom
 */
class NodeList implements \IteratorAggregate
{
    /**
     * @var \IteratorIterator
     */
    private $nodeList;

    /**
     * @var \Zend\View\Helper\EscapeHtml
     */
    private $escapeHtml;

    /**
     * @param  array|DOMNodeList $nodeList
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($nodeList)
    {
        if (is_array($nodeList) || $nodeList instanceof \DOMNodeList) {
            if (is_array($nodeList)) {
                $nodeList = new \ArrayObject($nodeList);
            }
            $this->nodeList = new \IteratorIterator($nodeList);
            return;
        }
        throw new Exception\InvalidArgumentException(
            'Expected nodeList as array or \DOMNodelist'
        );
    }

    /**
     * @param  array|DOMNodeList $nodeList
     * @return \WebinoDraw\Dom\NodeList
     */
    public function createNodeList($nodeList)
    {
        return new self($nodeList);
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->nodeList->getInnerIterator();
    }

    /**
     * @return \Zend\View\Helper\EscapeHtml
     */
    public function getEscapeHtml()
    {
        if (!$this->escapeHtml) {
            $this->setEscapeHtml(new EscapeHtml);
        }
        return $this->escapeHtml;
    }

    /**
     *
     * @param \Zend\View\Helper\EscapeHtml $escapeHtml
     */
    public function setEscapeHtml(EscapeHtml $escapeHtml)
    {
        $this->escapeHtml = $escapeHtml;
    }

    /**
     * Remove nodes mapped by xpath.
     *
     * @param string $xpath
     * @return \WebinoDraw\Dom\NodeList
     * @throws Exception\RuntimeException
     */
    public function remove($xpath = '.')
    {
        $remove = array();
        foreach ($this as $node) {
            if (empty($node->ownerDocument->xpath)) {
                throw new Exception\RuntimeException(
                    'Expects DOMDocument with XPath'
                );
            }
            $nodes = $node->ownerDocument->xpath->query($xpath, $node);
            foreach ($nodes as $subnode) {
                $remove[] = $subnode;
            }
        }
        foreach ($remove as $node) {
            $node->parentNode->removeChild($node);
        }
        return $this;
    }

    /**
     * Replace node with XHTML code.
     *
     * @param  string $xhtml
     * @return \WebinoDraw\Dom\NodeList
     */
    public function replace($xhtml)
    {
        $nodeList = new \ArrayObject;
        foreach ($this as $node) {
            if (empty($xhtml)) {
                $nodeList[] = $node;
                continue;
            }
            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($xhtml);
            $nodeList[] = $node->parentNode->insertBefore($frag, $node);
            $node->parentNode->removeChild($node);
        }
        $this->nodeList = new \IteratorIterator($nodeList);
        return $this;
    }

    /**
     * Set node text value.
     *
     * @param  string $value
     * @return \WebinoDraw\Dom\NodeList
     */
    public function setValue($value)
    {
        $escapeHtml = $this->getEscapeHtml();
        foreach ($this as $node) {
            $node->nodeValue = $escapeHtml($value);
        }
        return $this;
    }

    /**
     * Set html value to nodes.
     *
     * @param  string $xhtml
     * @param  Callable $preSet Modify and return xhtml. Passed parameters $node, $xhtml.
     * @return \WebinoDraw\Dom\NodeList
     */
    public function setHtml($xhtml, $preSet = null)
    {
        foreach ($this as $node) {
            if (is_callable($preSet)) {
                $xhtml = $preSet($node, $xhtml);
            }
            $node->nodeValue = '';
            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($xhtml);
            $node->appendChild($frag);
        }
        return $this;
    }

    /**
     * Set attributes to nodes.
     *
     * @param  array $attribs Attributes to set.
     * @param  Callable $preSet Modify and return value. Passed parameters $node, $value.
     * @return \WebinoDraw\Dom\NodeList
     * @throws Exception\RuntimeException
     */
    public function setAttribs(array $attribs, $preSet = null)
    {
        foreach ($this as $node) {
            if ($node instanceof \DOMElement) {
                foreach ($attribs as $name => $value) {
                    if (is_callable($preSet)) {
                        $value = $preSet($node, $value);
                    }
                    if (empty($value) && !is_numeric($value)) {
                        $node->removeAttribute($name);
                    } else {
                        $node->setAttribute($name, trim($value));
                    }
                }
                continue;
            }
            throw new Exception\RuntimeException('Invalid element ' . get_class($node));
        }
        return $this;
    }
}
