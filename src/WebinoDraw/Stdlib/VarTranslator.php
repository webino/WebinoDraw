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

use ArrayAccess;
use ArrayObject;
use WebinoDraw\Stdlib\ArrayFetchInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\Filter\FilterPluginManager;

/**
 * Replace variables in array with values in the other array.
 *
 * The first array is a specification with custom options
 * with {$variable} in values.
 *
 * The second array contains data by variable names like
 * keys. Those {$variable} will be substituted with data.
 */
class VarTranslator
{
    /**
     * Pattern of variable
     */
    const VAR_PATTERN = '{$%s}';


    /**
     * Match {$var} regular pattern
     *
     * @return string
     */
    protected function createVarPregPattern()
    {
        $pattern = str_replace('%s', '[^\}]+', preg_quote(self::VAR_PATTERN));
        return '~' . $pattern . '~';
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
     * Return true if {$var} is in the string
     *
     * @param string $string
     * @return bool
     */
    public function containsVar($string)
    {
        return (bool) preg_match($this->createVarPregPattern(), $string);
    }

    /**
     * Remove vars from string
     *
     * @param string $string
     * @return bool
     */
    public function removeVars($string)
    {
        $sanitized = preg_replace($this->createVarPregPattern(), '', $string);
        return trim($sanitized);
    }

    /**
     * Transform subject keys to {$var} like
     *
     * @param ArrayAccess $subject
     * @return ArrayAccess
     */
    public function makeVarKeys(ArrayAccess $subject)
    {
        $_subject = clone $subject;

        foreach ($subject as $key => $value) {

            $_subject->offsetSet($this->makeVar($key), $value);
            $_subject->offsetUnset($key);
        }

        return $_subject;
    }

    /**
     * Replace {$var} in string with data from translation
     *
     * If $str = {$var} and translation has item with key {$var} = array,
     * immediately return this array.
     *
     * @param string $str
     * @param ArrayAccess $translation
     * @return mixed
     */
    public function translateString($str, ArrayAccess $translation)
    {
        if (!is_string($str)) {
            return $str;
        }

        $match = array();
        preg_match_all($this->createVarPregPattern(), $str, $match);

        if (empty($match[0])) {
            return $str;
        }

        foreach ($match[0] as $key) {

            if (array_key_exists($key, $translation)) {

                if (is_object($translation[$key])) {
                    // return early for objects
                    // this is usefull to pass objects
                    // to functions, helpers and filters
                    return $translation[$key];
                }

                $str = str_replace($key, $translation[$key], $str);
            }
        }

        return $str;
    }

    /**
     * Replace {$var} in $subject with data from $translation
     *
     * @param string|array $subject
     * @param ArrayAcess $translation
     * @return VarTranslator
     */
    public function translate(&$subject, ArrayAccess $translation)
    {
        if (empty($subject)) {
            return $this;
        }

        if (is_string($subject)) {
            $subject = $this->translateString($subject, $translation);
            return $this;
        }

        if (!is_array($subject)) {
            return $this;
        }

        foreach ($subject as &$param) {

            if (is_array($param)) {

                $this->translate($param, $translation);
                continue;
            }

            $param = $this->translateString($param, $translation);
        }

        return $this;
    }

    /**
     * @param ArrayAccess $translation
     * @param array $values
     * @return VarTranslator
     */
    public function translationMerge(ArrayAccess $translation, array $values)
    {
        foreach ($values as $key => $value) {

            $this->translate($value, $translation);

            $translation[$key] = $value;
        }

        return $this;
    }

    /**
     * Set translated defaults into translation
     *
     * @param ArrayAccess $translation
     * @param array $defaults
     * @return array
     */
    public function translationDefaults(ArrayAccess $translation, array $defaults)
    {
        foreach ($defaults as $key => $value) {

            if (empty($translation[$key])) {

                $this->translate($value, $translation);

                $translation[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Fetch custom variables to translation
     *
     * example of properties:
     *
     * $translation = array(
     *     'value' => array(
     *         'in' => array(
     *             'the' => array(
     *                 'depth' => 'valueInTheDepth',
     *             ),
     *         ),
     *     ),
     * );
     *
     * example of options:
     *
     * $options = array(
     *     'customVar' => 'value.in.the.depth',
     * );
     *
     * @param array $translation
     * @param array $options
     * @return VarTranslator
     */
    public function translationFetch(ArrayFetchInterface $translation, array $options)
    {
        foreach ($options as $key => $basepath) {
            $translation[$key] = $translation->fetch($basepath);
        }

        return $this;
    }

    /**
     * Apply view helpers and functions on variables
     *
     * Call user function if exists else call helper
     *
     * @param ArrayAccess $translation Variables with values to modify
     * @param array $spec Helper options
     * @param AbstractPluginManager $pluginManager Helper loader
     * @return VarTranslator
     */
    public function applyHelper(ArrayAccess $translation, array $spec, AbstractPluginManager $pluginManager)
    {
        $results = new ArrayObject;

        foreach ($spec as $key => $value) {

            // skip undefined
            if (!array_key_exists($key, $translation)) {
                continue;
            }

            foreach ($value as $helper => $options) {

                if (function_exists($helper)) {

                    // php functions first

                    $this->translate(
                        $options,
                        $this->makeVarKeys($translation)
                    );

                    $translation[$key] = call_user_func_array($helper, $options);

                } else {

                    // zf helpers

                    $plugin = $pluginManager->get($helper);

                    foreach ($options as $func => $calls) {

                        foreach ($calls as $params) {

                            if (is_string($plugin)) {
                                break;
                            }

                            $translation->merge($results->getArrayCopy());

                            $this->translate(
                                $params,
                                $this->makeVarKeys($translation)
                            );

                            $plugin = call_user_func_array(
                                array($plugin, $func),
                                $params
                            );
                        }
                    }

                    !empty($results[$key]) or
                        $results[$key] = null;

                    // join helper result
                    $results[$key].= $plugin;
                }
            }
        }

        $translation->merge($results->getArrayCopy());

        return $this;
    }

    /**
     * Apply filters and functions on variables.
     *
     * Call user function if exists else call filter.
     *
     * @param  ArrayAccess $translation Variables with values to modify.
     * @param  array $spec Filter options.
     * @param  FilterPluginManager $pluginManager Filter loader.
     * @return VarTranslator
     */
    public function applyFilter(ArrayAccess $translation, array $spec, FilterPluginManager $pluginManager)
    {
        foreach ($spec as $key => $value) {

            // skip undefined
            if (!array_key_exists($key, $translation)) {
                continue;
            }

            foreach ($value as $helper => $options) {

                if (function_exists($helper)) {

                    // php functions first

                    $this->translate(
                        $options,
                        $this->makeVarKeys($translation)
                    );

                    $translation[$key] = call_user_func_array($helper, $options);

                } else {

                    // zf filter

                    $this->translate(
                        $options,
                        $this->makeVarKeys($translation)
                    );

                    if (empty($options[0])) {
                        $translation[$key] = '';
                        continue;
                    }

                    if (empty($options[1])) {
                        $options[1] = array();
                    }

                    $translation[$key] = $pluginManager
                                            ->get($helper, $options[1])
                                            ->filter($options[0]);
                }
            }
        }

        return $this;
    }

    /**
     * @param mixed $subject
     * @return array
     */
    public function subjectToArray($subject)
    {
        if (is_array($subject)) {
            return $subject;
        }

        if (!is_object($subject)) {
            throw new \InvalidArgumentException(
                'Expected array|object, but provided ' . gettype($subject)
            );
        }

        if (method_exists($subject, 'toArray')) {
            return $subject->toArray();
        }

        if (method_exists($subject, 'getArrayCopy')) {
            return $subject->getArrayCopy();
        }
    }
}
