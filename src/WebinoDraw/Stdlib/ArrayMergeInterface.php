<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Stdlib;

use ArrayAccess;

/**
 *
 */
interface ArrayMergeInterface extends ArrayAccess
{
    /**
     * @param array $array
     * @return ArrayMergeInterface
     */
    public function merge(array $array);
}
