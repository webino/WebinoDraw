<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Dom;

use ArrayObject;
use DOMNodeList;
use IteratorAggregate;
use IteratorIterator;
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
     * @param array|DOMNodeList $nodes DOMNodes in array or DOMNodelist
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct($nodes = null)
    {
        (null === $nodes) or
            $this->setNodes($nodes);
    }

    /**
     * @param array|DOMNodeList $nodes DOMNodes in array or DOMNodelist
     * @return NodeList
     */
    public function createNodeList($nodes)
    {
        return new self($nodes);
    }

    /**
     * @return IteratorIterator
     */
    public function getNodes()
    {
        if (null === $this->nodes) {
            $this->setNodes(array());
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

        throw new InvalidArgumentException(
            'Expected nodes as array|DOMNodelist'
        );
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

            if (is_callable($preSet)) {

                $nodeValue = $preSet($node, $value);

            } else {

                $nodeValue = $value;
            }

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

            if (is_callable($preSet)) {

                $nodeXhtml = $preSet($node, $xhtml);

            } else {

                $nodeXhtml = $xhtml;
            }

            $node->nodeValue = '';

            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($nodeXhtml);

            $node->appendChild($frag);
        }

        return $this;
    }

    /**
     * Set nodes attributes
     *
     * @param  array $attribs Attributes to set
     * @param  Callable $preSet Modify and return value, assed parameters $node, $value
     * @return NodeList
     * @throws RuntimeException
     */
    public function setAttribs(array $attribs, $preSet = null)
    {
        foreach ($this as $node) {

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
        $remove   = array();
        $nodeList = new ArrayObject;

        foreach ($this as $node) {

            if (is_callable($preSet)) {

                $nodeXhtml = $preSet($node, $xhtml);

            } else {

                $nodeXhtml = $xhtml;
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
     * @param string $xpath
     * @return NodeList
     * @throws RuntimeException
     */
    public function remove($xpath = '.')
    {
        $remove = array();

        foreach ($this as $node) {

            if (empty($node->ownerDocument->xpath)) {
                throw new RuntimeException(
                    'Expects DOMDocument with xpath'
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
}
