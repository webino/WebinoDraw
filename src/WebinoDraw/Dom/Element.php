<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Dom;

/**
 * Extended DOMElement
 */
class Element extends \DOMElement
{
    const NODE_VALUE_PROPERTY = 'nodeValue';

    /**
     * Attributes mass assignment
     *
     * @param array $attribs
     * @param callable $callback Called on each attribute value
     * @return self
     */
    public function setAttributes(array $attribs, $callback = null)
    {
        foreach ($attribs as $name => $value) {

            !is_callable($callback) or
                $value = $callback($value, $name);

            if (empty($value) && !is_numeric($value)) {
                $this->removeAttribute($name);
            } else {
                $this->setAttribute($name, trim($value));
            }
        }

        return $this;
    }

    /**
     * Returns the node body html
     *
     * @return string
     */
    public function getInnerHtml()
    {
        $innerHtml = '';

        foreach ($this->childNodes as $child) {

            $childHtml = trim($child->ownerDocument->saveXML($child));

            empty($childHtml) or
                $innerHtml.= $childHtml;
        }

        return $innerHtml;
    }

    /**
     * Returns the node html
     *
     * @return string
     */
    public function getOuterHtml()
    {
        return trim($this->ownerDocument->saveXML($this));
    }

    /**
     * Returns the node text value and attributes in the array
     *
     * @return array
     */
    public function getProperties($prefix = null)
    {
        $properties = array(
            $prefix . self::NODE_VALUE_PROPERTY => '',
        );

        empty($this->nodeValue) or
            $properties[$prefix . self::NODE_VALUE_PROPERTY] = $this->nodeValue;


        if (empty($this->attributes)) {
            return $properties;
        }

        foreach ($this->attributes as $attr) {
            $properties[$prefix . $attr->name] = $attr->value;
        }

        return $properties;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $nodeValue = trim($this->nodeValue);

        if (!empty($nodeValue)
            || is_numeric($nodeValue)
        ) {
            return false;
        }

        // node value is empty,
        // chceck for childs other than text
        foreach ($this->childNodes as $childNode) {
            if (!($childNode instanceof \DOMText)) {
                return false;
            }
        }

        return true;
    }
}
