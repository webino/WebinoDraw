<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

use ArrayObject;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Exception\UnexpectedValueException;
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
     * @param Transformator $transformator
     * @param string|array $input
     */
    public function __construct(Transformator $transformator, $input = null)
    {
        $this->transformator = $transformator;
        empty($input) or
            $this->set($input);
    }

    /**
     * @param string|array $input
     * @return self
     * @throws UnexpectedValueException
     */
    public function set($input)
    {
        if (is_string($input)) {
            $this->exchangeArray([$input]);
            return $this;

        } elseif (is_array($input)) {
            $this->exchangeArray($input);
            return $this;

        }

        throw new UnexpectedValueException('Expected input as string or array, but provided ' . gettype($input));
    }

    /**
     * @param Element $node
     * @param string $locator
     * @return \DOMNodeList
     * @throws InvalidArgumentException
     */
    public function locate(Element $node, $locator)
    {
        if (!($node->ownerDocument instanceof Document)) {
            throw new InvalidArgumentException('Expects Dom\Document');
        }
        return $node->ownerDocument->getXpath()->query($this->set($locator)->xpathMatchAny(), $node);
    }

    /**
     * @param array $array
     * @return self
     */
    public function merge(array $array)
    {
        $this->exchangeArray(array_merge($this->getArrayCopy(), $array));
        return $this;
    }

    /**
     * Xpath joined by OR
     *
     * @return string
     */
    public function xpathMatchAny()
    {
        $xpath = [];
        foreach ($this->getArrayCopy() as $locator) {
            $xpath[] = $this->transformator->locator2Xpath($this->normalizeLocator($locator));
        }

        return join('|', $xpath);
    }

    /**
     * @param string $locator
     * @return string
     */
    private function normalizeLocator($locator)
    {
        if (false === strpos($locator, PHP_EOL)) {
            return $locator;
        }
        return preg_replace('~[[:space:]]+~', ' ', $locator);
    }
}
