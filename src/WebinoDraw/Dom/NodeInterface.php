<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

/**
 * Interface NodeInterface
 */
interface NodeInterface
{
    /**
     * Node cache key attribute name
     */
    const CACHE_KEY_ATTR = '__cacheKey';

    /**
     * Node value attribute name key
     */
    const NODE_VALUE_PROPERTY = 'nodeValue';
}
