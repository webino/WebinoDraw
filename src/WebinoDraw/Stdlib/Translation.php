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
     * @param string $basePath Something like: value.in.the.depth
     * @return mixed Result value
     */
    public function fetch($basePath)
    {
        $value = $this->getArrayCopy();
        $parts = [];

        preg_match_all('~[^\.]+\\\.[^\.]+|[^\.]+~', $basePath, $parts);

        foreach ($parts[0] as $key) {
            // magic keys
            if ('_first' === $key) {
                reset($value);
                $key = key($value);

            } elseif ('_last' === $key) {
                end($value);
                $key = key($value);
            }

            // unescape
            $key = str_replace('\.', '.', $key);

            // undefined
            if (!array_key_exists($key, $value)) {
                $value = null;
                break;
            }

            $value = &$value[$key];

            // array only
            if (!is_array($value) && !($value instanceof ArrayObject)) {
                if (is_object($value)) {
                    if (method_exists($value, 'toArray')) {
                        $value = $value->toArray();
                    } elseif (method_exists($value, 'getArrayCopy')) {
                        $value = $value->getArrayCopy();
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
        }

        return $value;
    }

    /**
     * @param array $array
     * @return self
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

    /**
     * @param array $keys
     * @return self
     */
    public function unsetKeys(array $keys)
    {
        foreach ($keys as $key) {
            unset($this[$key]);
        }

        return $this;
    }
}
