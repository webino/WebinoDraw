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

use Zend\Dom\Css2Xpath;
use Zend\View\Helper;

/**
 * @category    Webino
 * @package     WebinoDraw_Dom
 */
class NodeList implements \IteratorAggregate
{
    private $nodeList = null;
    private $escapeHtml = null;

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

    public function getIterator()
    {
        return $this->nodeList->getInnerIterator();
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

    public function remove($xpath = '.')
    {
        foreach ($this as $node)
            foreach ($node->ownerDocument->xpath->query($xpath, $node) as $subnode)
                $subnode->parentNode->removeChild($subnode);
        return $this;
    }

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

    public function setValue($value)
    {
        $escapeHtml = $this->getEscapeHtml();
        foreach ($this as $node)
            $node->nodeValue = $escapeHtml($value);
        return $this;
    }

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
}
