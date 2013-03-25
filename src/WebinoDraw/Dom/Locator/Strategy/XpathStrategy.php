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

use WebinoDraw\Dom\Locator\TransformatorInterface;

/**
 *
 */
class XpathStrategy implements TransformatorInterface
{
    /**
     * @param string $locator
     * @return string
     */
    public function locator2Xpath($locator)
    {
        return $locator;
    }
}
