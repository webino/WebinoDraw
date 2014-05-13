<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */
namespace WebinoDraw\Ajax;

use ArrayObject;
use WebinoDraw\Stdlib\ArrayMergeInterface;

/**
 *
 */
class Json extends ArrayObject implements
    ArrayMergeInterface
{
    /**
     * @param array $array
     * @return Json
     */
    public function merge(array $array)
    {
        $this->exchangeArray(
            array_replace_recursive(
                $this->getArrayCopy(),
                $array
            )
        );

        return $this;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->getArrayCopy());
    }
}
