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

/**
 * DOMXpath utilities.
 *
 * @category    Webino
 * @package     WebinoDraw_Dom
 */
abstract class XpathUtils
{
    /**
     * If XPath is string return it as array.
     *
     * @param  string|array $xpath
     * @return array
     */
    public static function arrayXpath($xpath)
    {
        if (is_array($xpath)) {
            return $xpath;
        }
        return array($xpath);
    }

    /**
     * Transform string or array css selectors to XPath.
     *
     * @param  string|array $selector
     * @return array
     */
    public static function arrayCss2Xpath($selector)
    {
        if (is_array($selector)) {
            return array_map(
                function($value) {
                    return '.' . Css2Xpath::transform($value);
                },
                $selector
            );
        }
        return array('.' . Css2Xpath::transform($selector));
    }
}
