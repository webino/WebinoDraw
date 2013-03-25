<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Dom;

use ArrayObject;
use UnexpectedValueException;
use WebinoDraw\Dom\Locator\Transformator;

/**
 *
 */
class Locator extends ArrayObject
{
    /**
     * @var Transformator
     */
    protected $transformator;

    /**
     * @param string|array $input
     * @throws UnexpectedValueException
     */
    public function __construct($input = null)
    {
        if (null !== $input) {
            $this->set($input);
        }
    }

    /**
     * @param string|array $input
     * @return Locator
     * @throws UnexpectedValueException
     */
    public function set($input)
    {
        if (is_string($input)) {

            $this->exchangeArray(array($input));
            return $this;

        } elseif (is_array($input)) {

            $this->exchangeArray($input);
            return $this;

        }

        throw new UnexpectedValueException(
            'Expected input as string or array, but provided ' . gettype($input)
        );
    }

    /**
     * @return Transformator
     */
    public function getTransformator()
    {
        if (null == $this->transformator) {
            $this->setTransformator(new Transformator);
        }

        return $this->transformator;
    }

    /**
     * @param Transformator $transformator
     * @return Locator
     */
    public function setTransformator(Transformator $transformator)
    {
        $this->transformator = $transformator;
        return $this;
    }

    /**
     * @param array $array
     * @return Locator
     */
    public function merge(array $array)
    {
        $this->exchangeArray(
            array_merge(
               $this->getArrayCopy(),
               $array
           )
        );

        return $this;
    }

    /**
     * Xpath joined by OR
     *
     * @return string
     */
    public function xpathMatchAny()
    {
        $strategy = $this->getTransformator();
        $xpath    = array();

        foreach ($this->getArrayCopy() as $locator) {
            $xpath[] = $strategy->locator2Xpath($locator);
        }

        return join('|', $xpath);
    }
}