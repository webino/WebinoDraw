<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Dom\Locator\Strategy;

use WebinoDraw\Dom\Locator\TransformatorInterface;
use Zend\Dom\Document\Query as DomQuery;

/**
 *
 */
class CssStrategy implements TransformatorInterface
{
    /**
     * @param string $locator
     * @return string
     */
    public function locator2Xpath($locator)
    {
        if (0 === strpos($locator, '//')) {
            // return early for absolute
            return DomQuery::cssToXpath(substr($locator, 2));
        }
        // dot makes it relative
        return '.' . DomQuery::cssToXpath($locator);
    }
}
