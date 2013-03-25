<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Dom\Locator\Strategy;

use WebinoDraw\Dom\Locator\AbstractStrategy;
use Zend\Dom\Css2Xpath;

/**
 *
 */
class CssStrategy extends AbstractStrategy
{
    /**
     * @param string $locator
     * @return string
     */
    public function locator2Xpath($locator)
    {
        // dot makes it relative
        return '.' . Css2Xpath::transform($locator);
    }
}
