<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper\Absolutize;

/**
 * 
 */
class AbsolutizeLocator
{
    /**
     * Default condition for the locator
     *
     * @return string
     */
    public function getCondition()
    {
        return '[not(starts-with(., "http"))
            and not(starts-with(., "#"))
            and not(starts-with(., "?"))
            and not(starts-with(., "/"))
            and not(starts-with(., "mailto:"))
            and not(starts-with(., "javascript:"))
            and not(../@data-webino-draw-absolutize="no")]';
    }

    /**
     * The default locator of attributes to absolutize
     *
     * @return array
     */
    public function getLocator()
    {
        return [
            'src'    => 'xpath=//@src' . $this->getCondition(),
            'href'   => 'xpath=//@href' . $this->getCondition(),
            'action' => 'xpath=//@action' . $this->getCondition(),
        ];
    }
}
