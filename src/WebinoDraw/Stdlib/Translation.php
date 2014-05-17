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
use ArrayObject;
use WebinoDraw\Dom\Element;

/**
 *
 */
class Translation extends ArrayObject implements
    ArrayFetchInterface,
    ArrayMergeInterface
    // TODO implement
//    NodeTranslationInterface
{
    /**
     * Pattern of a variable
     */
    const VAR_PATTERN = '{$%s}';

    /**
     * Prefix of the extra variables to avoid conflicts
     */
    const EXTRA_VAR_PREFIX = '_';

    /**
     * Pattern to match variables
     *
     * @var string
     */
    protected $varPregPattern;

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
        if (!empty($array)) {
            $this->exchangeArray(array_merge($this->getArrayCopy(), $array));
        }
        return $this;
    }

    /**
     * @param array $keys
     * @return self
     */
    public function unsetKeys(array $keys)
    {
        foreach ($keys as $key) {
            if (isset($this[$key])) {
                unset($this[$key]);
            }
        }
        return $this;
    }

    public function createNodeTranslation(Element $node, array $spec)
    {
        $translation     = new self($node->getProperties(self::EXTRA_VAR_PREFIX));
        $htmlTranslation = $this->createNodeHtmlTranslation($node, $spec);

        $translation->merge($htmlTranslation->getArrayCopy());
        return $translation;
    }

    public function createNodeHtmlTranslation(Element $node, array $spec)
    {
        $translation  = new self;
        $innerHtmlKey = $this->makeExtraVarKey('innerHtml');
        $outerHtmlKey = $this->makeExtraVarKey('outerHtml');

        foreach (['html', 'replace'] as $key) {
            if (empty($spec[$key])) {
                continue;
            }

            if (false !== strpos($spec[$key], $innerHtmlKey)) {
                // include node innerHTML to the translation
                $translation[$innerHtmlKey] = $node->getInnerHtml();
            }

            if (false !== strpos($spec[$key], $outerHtmlKey)) {
                // include node outerHTML to the translation
                $translation[$outerHtmlKey] = $node->getOuterHtml();
            }
        }

        return $translation;
    }

    public function createNodeVarTranslationArray(Element $node, array $spec)
    {
        return $this->createNodeHtmlTranslation($node, $spec)->getVarTranslation()->getArrayCopy();
    }

    public function getVarTranslation()
    {
        return $this->makeVarKeys($this);
    }

    public function makeExtraVarKey($varKey)
    {
        return self::EXTRA_VAR_PREFIX . $varKey;
    }

    /**
     * Transform varname into {$varname}.
     *
     * @param string $key
     * @return string
     */
    public function makeVar($key)
    {
        return sprintf(self::VAR_PATTERN, $key);
    }

    /**
     * Transform subject keys to {$var} like
     *
     * @param ArrayAccess $subject
     * @return ArrayAccess
     */
    public function makeVarKeys(ArrayAccess $subject)
    {
        $subjectClone = clone $subject;

        foreach ($subject as $key => $value) {
            $subjectClone->offsetSet($this->makeVar($key), $value);
            $subjectClone->offsetUnset($key);
        }

        return $subjectClone;
    }

    /**
     * Match {$var} regular pattern
     *
     * @return string
     */
    public function getVarPregPattern()
    {
        if (null === $this->varPregPattern) {
            $pattern = str_replace('%s', '[^\}]+', preg_quote(self::VAR_PATTERN));
            $this->varPregPattern = '~' . $pattern . '~';
        }
        return $this->varPregPattern;
    }

    /**
     * Return true if {$var} is in the string
     *
     * @param string $string
     * @return bool
     */
    public function containsVar($string)
    {
        return (bool) preg_match($this->getVarPregPattern(), $string);
    }

    /**
     * Remove vars from string
     *
     * @param string $string
     * @return bool
     */
    public function removeVars($string)
    {
        if (!is_string($string)
            || !$this->containsVar($string)
        ) {
            return $string;
        }

        return trim(preg_replace($this->getVarPregPattern(), '', $string));
    }
}
