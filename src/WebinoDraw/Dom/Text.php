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

/**
 * Extended DOMText
 */
class Text extends \DOMText implements NodeInterface
{
    const NODE_VALUE_PROPERTY = 'nodeValue';

    /**
     * Returns the node text value and attributes in the array
     *
     * @return array
     */
    public function getProperties($prefix = null)
    {
        $properties = [$prefix . self::NODE_VALUE_PROPERTY => ''];

        empty($this->nodeValue) or
            $properties[$prefix . self::NODE_VALUE_PROPERTY] = $this->nodeValue;

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

        return true;
    }
}