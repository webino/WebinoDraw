<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Stdlib;

use ArrayAccess;

/**
 *
 */
interface ArrayFetchInterface extends ArrayAccess
{
    /**
     * Return value in depth from multidimensional array
     *
     * @param string $basepath Something like: value.in.the.depth
     * @return ArrayFetchInterface
     */
    public function fetch($basepath);
}
