<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Ajax;

/**
 *
 */
class FragmentXpath
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @param string $string
     */
    public function __construct($string = null)
    {
        (null === $string) or
            $this->set($string);
    }

    /**
     * @param string $string
     * @return FragmentXpath
     * @throws \UnexpectedValueException
     */
    public function set($string)
    {
        if (!is_string($string)) {
            throw new \UnexpectedValueException(
                'Expected string, but provided ' . gettype($string)
            );
        }

        $this->content = $string;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }
}
