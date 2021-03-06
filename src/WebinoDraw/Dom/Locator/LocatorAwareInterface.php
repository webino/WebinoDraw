<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2016-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom\Locator;

use WebinoDraw\Dom\Locator;

/**
 * Interface LocatorAwareInterface
 */
interface LocatorAwareInterface
{
    public function setLocator(Locator $locator);
}
