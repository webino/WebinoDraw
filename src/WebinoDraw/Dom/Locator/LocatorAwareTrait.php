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
use WebinoDraw\Exception;

/**
 * Class LocatorAwareTrait
 */
trait LocatorAwareTrait
{
    /**
     * @var Locator
     */
    private $locator;

    /**
     * @return Locator
     */
    protected function getLocator()
    {
        if (null === $this->locator) {
            throw new Exception\RuntimeException(
                'Expects `' . Locator::class . '` injected'
            );
        }
        return $this->locator;
    }

    /**
     * @param Locator $locator
     * @return $this
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
        return $this;
    }
}
