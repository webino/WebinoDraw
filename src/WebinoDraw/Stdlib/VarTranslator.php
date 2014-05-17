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
use WebinoDraw\Exception;
use WebinoDraw\Stdlib\ArrayFetchInterface;
use Zend\View\HelperPluginManager;
use Zend\Filter\FilterPluginManager;
use Zend\View\Helper\HelperInterface;

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
     * @var HelperPluginManager
     */
    protected $helpers;

    /**
     * @var FilterPluginManager
     */
    protected $filters;

    /**
     * @param HelperPluginManager $helpers
     * @param FilterPluginManager $filters
     */
    public function __construct(HelperPluginManager $helpers, FilterPluginManager $filters)
    {
        $this->helpers = $helpers;
        $this->filters = $filters;
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

        $match = [];
        preg_match_all($translation->getVarPregPattern(), $str, $match);

        if (empty($match[0])) {
            return $str;
        }

        foreach ($match[0] as $key) {
            if (!array_key_exists($key, $translation)) {
                continue;
            }

            if ($key === $str
                && (is_object($translation[$key])
                    || is_array($translation[$key])
                    || is_int($translation[$key])
                    || is_float($translation[$key]))
            ) {
                // return early for non-strings
                // this is usefull to pass subjects
                // to functions, helpers and filters
                return $translation[$key];
            }

            $str = str_replace($key, $translation[$key], $str);
        }

        return $str;
    }

    /**
     * Replace {$var} in $subject with data from $translation
     *
     * @param string|array $subject
     * @param ArrayAcess $translation
     * @return self
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
     * @return self
     */
    public function translationMerge(ArrayAccess $translation, array $values)
    {
        foreach ($values as $key => $value) {
            $this->translate($value, $translation->getVarTranslation());
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
            if (!empty($translation[$key])
                || (array_key_exists($key, $translation)
                    && is_numeric($translation[$key]))
            ) {
                continue;
            }

            $this->translate($value, $translation->getVarTranslation());
            $translation[$key] = $value;
        }

        return $this;
    }

    /**
     * Fetch custom variables to translation
     *
     * example of properties:
     *
     * $translation = [
     *     'value' => [
     *         'in' => [
     *             'the' => [
     *                 'depth' => 'valueInTheDepth',
     *             ],
     *         ],
     *     ],
     * ];
     *
     * example of options:
     *
     * $options = [
     *     'customVar' => 'value.in.the.depth',
     * ];
     *
     * @param array $translation
     * @param array $options
     * @return self
     */
    public function translationFetch(ArrayFetchInterface $translation, array $options)
    {
        foreach ($options as $key => $basepath) {
            $translation[$key] = $translation->fetch(
                $this->translateString($basepath, $translation->getVarTranslation())
            );
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
     * @return self
     */
    public function applyHelper(ArrayAccess $translation, array $spec)
    {
        $results = new ArrayObject;

        foreach ($spec as $key => $subSpec) {
            if (!array_key_exists($key, $translation)) {
                // skip undefined
                continue;
            }

            $joinResult = true;
            foreach ((array) $subSpec as $helper => $options) {

                if ('_join_result' === $helper) {
                    // option to disable the string result joining
                    $joinResult = (bool) $options;
                    continue;
                }

                if (!empty($options['helper'])) {
                    // helper is not an options key
                    $helper = $options['helper'];
                    unset($options['helper']);
                }

                if (function_exists($helper)) {
                    // php functions first

                    $translation->merge($results->getArrayCopy());
                    $this->translate($options, $translation->getVarTranslation());

                    $results[$key] = call_user_func_array($helper, $options);

                } else {
                    // zf helpers
                    $plugin = $this->helpers->get($helper);

                    foreach ($options as $func => $calls) {
                        if (null === $calls) {
                            continue;
                        }

                        foreach ($calls as $params) {
                            if (null === $params) {
                                continue;
                            }

                            $translation->merge($results->getArrayCopy());
                            $this->translate($params, $translation->getVarTranslation());

                            $plugin = call_user_func_array([$plugin, $func], $params);
                            if (is_string($plugin)) {
                                break;
                            }

                            if (!($plugin instanceof HelperInterface)
                                || is_array($plugin)
                                || is_int($plugin)
                                || is_float($plugin)
                            ) {
                                // support array results
                                $results[$key] = $plugin;
                                continue 3;
                            }
                        }
                    }

                    !empty($results[$key]) or
                        $results[$key] = null;

                    if ($joinResult) {
                        // join helper result
                        $results[$key].= $plugin;
                    } else {
                        $results[$key] = $plugin;
                    }
                }
            }
        }

        $translation->merge($results->getArrayCopy());
        return $this;
    }

    /**
     * Apply filters and functions on variables
     *
     * Call user function if exists else call filter.
     *
     * @param  ArrayAccess $translation Variables with values to modify.
     * @param  array $spec Filter options.
     * @return self
     */
    public function applyFilter(ArrayAccess $translation, array $spec)
    {
        foreach ($spec as $key => $subSpec) {
            if (!array_key_exists($key, $translation)) {
                // skip undefined
                continue;
            }

            foreach ((array) $subSpec as $helper => $options) {

                if (function_exists($helper)) {
                    // php functions first
                    $this->translate($options, $translation->getVarTranslation());
                    $translation[$key] = call_user_func_array($helper, $options);

                } else {
                    // zf filter
                    $this->translate($options, $translation->getVarTranslation());

                    if (empty($options[0])) {
                        $translation[$key] = '';
                        continue;
                    }

                    !empty($options[1]) or
                        $options[1] = [];

                    $translation[$key] = $this->filters
                                            ->get($helper, $options[1])
                                            ->filter($options[0]);
                }
            }
        }

        return $this;
    }

    /**
     * Apply variable logic
     *
     * @todo refactor
     *
     * @param ArrayAccess $varTranslation
     * @param array $spec
     * @param Callable $callback
     * @return self
     * @throws Exception\InvalidInstructionException
     */
    public function applyOnVar(ArrayAccess $varTranslation, array $spec, $callback)
    {
        foreach ($spec as $spec) {
            if (!array_key_exists('var', $spec)) {
                throw new Exception\InvalidInstructionException(
                    'Expected `var` option in ' . print_r($spec, true)
                );
            }

            $value = $varTranslation->removeVars(
                $this->translateString($spec['var'], $varTranslation)
            );

            !array_key_exists('equalTo', $spec) or
                $this->performOnVar(
                    $varTranslation,
                    $value,
                    $spec['equalTo'],
                    function ($value, $expected) use ($spec, $callback) {

                        $value != $expected or
                            $callback($spec);
                    }
                );

            !array_key_exists('notEqualTo', $spec) or
                $this->performOnVar(
                    $varTranslation,
                    $value,
                    $spec['notEqualTo'],
                    function ($value, $expected) use ($spec, $callback) {

                        $value == $expected or
                            $callback($spec);
                    }
                );

            !array_key_exists('lessThan', $spec) or
                $this->performOnVar(
                    $varTranslation,
                    $value,
                    $spec['lessThan'],
                    function ($value, $expected) use ($spec, $callback) {

                        $value >= $expected or
                            $callback($spec);
                    }
                );

            !array_key_exists('greaterThan', $spec) or
                $this->performOnVar(
                    $varTranslation,
                    $value,
                    $spec['greaterThan'],
                    function ($value, $expected) use ($spec, $callback) {

                        $value <= $expected or
                            $callback($spec);
                    }
                );
        }

        return $this;
    }

    /**
     * @param ArrayAccess $varTranslation
     * @param mixed $value
     * @param mixed $expected
     * @param Callable $callback
     */
    private function performOnVar(ArrayAccess $varTranslation, $value, $expected, $callback)
    {
        $expected = $varTranslation->removeVars(
            $this->translateString(
                $expected,
                $varTranslation
            )
        );

        $this->onVarFixTypes($value, $expected);
        $callback($value, $expected);
    }

    /**
     * Fix value types for equation
     *
     * @param mixed $valA
     * @param mixed $valB
     * @return AbstractDrawElement
     */
    private function onVarFixTypes(&$valA, &$valB)
    {
        if (empty($valA) && is_array($valA)) {
            $valA = (string) null;
            $valB = (string) $valB;
            return $this;
        }

        if (is_numeric($valA)) {
            $valA = (float) $valA;
            $valB = (float) $valB;
            return $this;
        }

        if (is_string($valA)) {
            $valA = (string) $valA;
            $valB = (string) $valB;
            return $this;
        }

        return $this;
    }

    public function apply(ArrayAccess $translation, array $spec)
    {
        empty($spec['var']['default']) or
            $this->translationDefaults($translation, $spec['var']['default']);

        empty($spec['var']['set']) or
            $this->translationMerge($translation, $spec['var']['set']);

        empty($spec['var']['fetch']) or
            $this->translationFetch($translation, $spec['var']['fetch']);

        empty($spec['var']['filter']['pre']) or
            $this->applyFilter($translation, $spec['var']['filter']['pre']);

        empty($spec['var']['helper']) or
            $this->applyHelper($translation, $spec['var']['helper']);

        empty($spec['var']['filter']['post']) or
            $this->applyFilter($translation, $spec['var']['filter']['post']);

        empty($spec['var']['default']) or
            $this->translationDefaults($translation, $spec['var']['default']);

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
            return [$subject];
        }

        if (method_exists($subject, 'toArray')) {
            return $subject->toArray();
        }

        if (method_exists($subject, 'getArrayCopy')) {
            return $subject->getArrayCopy();
        }
    }

    /**
     * @param mixed $subject
     * @return \ArrayObject
     */
    public function subjectToArrayObject($subject)
    {
        return new ArrayObject($this->subjectToArray($subject));
    }
}
