<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Stdlib;

use ArrayObject;

/**
 *
 */
class Translation extends ArrayObject implements
    ArrayFetchInterface,
    ArrayMergeInterface
{
    /**
     * Return value in depth from multidimensional array
     *
     * @param string $basepath Something like: value.in.the.depth
     * @return mixed Result value
     */
    public function fetch($basepath)
    {
        $value = $this->getArrayCopy();
        $parts = explode('.', $basepath);

        foreach ($parts as $key) {

            // magic keys
            if ('_first' === $key) {
                reset($value);
                $key = key($value);

            } elseif ('_last' === $key) {
                end($value);
                $key = key($value);
            }

            // undefined
            if (empty($value[$key])) {
                $value = null;
                break;
            }

            $value = &$value[$key];
        }

        return $value;
    }

    /**
     * @param array $array
     * @return Translation
     */
    public function merge(array $array)
    {
        if (empty($array)) {
            return $this;
        }

        $this->exchangeArray(
            array_merge(
                $this->getArrayCopy(),
                $array
            )
        );

        return $this;
    }
}
