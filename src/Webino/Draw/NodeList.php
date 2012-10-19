<?php
/**
 * Webino (http://zf.webino.org/)
 *
 * @copyright   Copyright (c) 2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license     New BSD License
 * @package     WebinoDraw
 */

namespace Webino\Draw;

use Zend\Dom\Css2Xpath;
use Zend\View\Helper;

/**
 * @category    Webino
 * @package     WebinoDraw
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class NodeList implements \IteratorAggregate
{
    private $nodeList = null;
    private $escapeHtml = null;
    private $escapeHtmlAttr = null;

    public function __construct($nodeList)
    {
        if (is_array($nodeList) || $nodeList instanceof \DOMNodeList) {
            if (is_array($nodeList)) $nodeList = new \ArrayObject($nodeList);
            $this->nodeList = new \IteratorIterator($nodeList);
            return;
        }
        throw new Exception\InvalidArgumentException(
            'Expected nodeList as array or \DOMNodelist'
        );
    }

    public function getIterator()
    {
        return $this->nodeList;
    }

    public function getEscapeHtml()
    {
        if (null === $this->escapeHtml)
            $this->setEscapeHtml(new Helper\EscapeHtml);
        return $this->escapeHtml;
    }

    public function setEscapeHtml($escapeHtml)
    {
        $this->escapeHtml = $escapeHtml;
    }

    public function getEscapeHtmlAttr()
    {
        if (null === $this->escapeHtmlAttr)
            $this->setEscapeHtmlAttr(new Helper\EscapeHtmlAttr);
        return $this->escapeHtmlAttr;
    }

    public function setEscapeHtmlAttr($escapeHtmlAttr)
    {
        $this->escapeHtmlAttr = $escapeHtmlAttr;
        return $this;
    }

    public function remove($xpath = '.')
    {
        foreach ($this->nodeList as $node)
            foreach ($node->ownerDocument->xpath->query($xpath, $node) as $subnode)
                $subnode->parentNode->removeChild($subnode);
        return $this;
    }

    public function replace($xhtml)
    {
        $nodeList = new \ArrayObject;
        foreach ($this->nodeList as $node) {
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

    public function setValue($value)
    {
        $escapeHtml = $this->getEscapeHtml();
        foreach ($this->nodeList as $node)
            $node->nodeValue = $escapeHtml($value);
        return $this;
    }

    public function setAttribs(array $attribs)
    {
        $escapeHtmlAttr = $this->getEscapeHtmlAttr();
        foreach ($this->nodeList->getInnerIterator() as $node) {
            if ($node instanceof \DOMElement) {
                foreach ($attribs as $name => $value) {
                    if (empty($value) && !is_numeric($value)) {
                        $node->removeAttribute($name);
                    } else {
                        $node->setAttribute($name, $escapeHtmlAttr(trim($value)));
                    }
                }
                continue;
            }
            throw new Exception\RuntimeException('Invalid element ' . get_class($node));
        }
        return $this;
    }

    public function setHtml($xhtml)
    {
        foreach ($this->nodeList as $node) {
            if (empty($xhtml)) {
                $node->nodeValue = '';
                continue;
            }
            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($xhtml);
            $node->appendChild($frag);
        }
        return $this;
    }
}
