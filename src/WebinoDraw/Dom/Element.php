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

/**
 * Extended DOMElement
 */
class Element extends \DOMElement
{
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
        $properties = array();

        empty($this->nodeValue) or
            $properties[$prefix . 'nodeValue'] = $this->nodeValue;

        foreach ($this->attributes as $attr) {
            $properties[$prefix . $attr->name] = $attr->value;
        }

        return $properties;
    }
}
