<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\VarTranslator\Operation;

use ArrayObject;
use WebinoDraw\Exception;
use WebinoDraw\VarTranslator\Translation;
use Zend\View\HelperPluginManager;
use Zend\View\Helper\HelperInterface;

/**
 * @todo refactor
 */
class Helper
{
    /**
     * @var HelperPluginManager
     */
    protected $helpers;

    /**
     * @param HelperPluginManager $helpers
     */
    public function __construct(HelperPluginManager $helpers)
    {
        $this->helpers = $helpers;
    }

    /**
     * Apply functions and view helpers on variables
     *
     * Call function if exists else call helper.
     *
     * @param Translation $translation Variables with values to modify
     * @param array $spec Helper options
     * @return self
     */
    public function apply(Translation $translation, array $spec)
    {
        $results = new ArrayObject;
        foreach ($spec as $key => $subSpec) {
            if ($translation->offsetExists($key)) {
                $this->iterateHelperSpec((array) $subSpec, $key, $translation, $results);
            }
        }

        $translation->merge($results->getArrayCopy());
        return $this;
    }

    /**
     * @param array $spec
     * @param mixed $key
     * @param Translation $translation
     * @param ArrayObject $results
     * @return self
     * @throws Exception\InvalidInstructionException
     */
    protected function iterateHelperSpec(array $spec, $key, Translation $translation, ArrayObject $results)
    {
        $joinResult = true;
        foreach ($spec as $helper => $options) {
            if ('_join_result' === $helper) {
                // option to disable the string result joining
                $joinResult = (bool) $options;
                continue;
            }

            if (!is_array($options)) {
                throw new Exception\InvalidInstructionException(
                    'Expected array options for spec ' . print_r($spec, true)
                );
            }

            if (!empty($options['helper'])) {
                // helper is not an options key
                $helper = $options['helper'];
                unset($options['helper']);
            }

            $this->callCallableHelper($helper, $key, $translation, $results, $options) or
                $this->callHelper($helper, $key, $translation, $results, $options, $joinResult);
        }

        return $this;
    }

    /**
     * @param mixed $helper
     * @param mixed $key
     * @param Translation $translation
     * @param ArrayObject $results
     * @param array $options
     * @return bool
     * @throws Exception\InvalidInstructionException
     */
    protected function callCallableHelper(
        $helper,
        $key,
        Translation $translation,
        ArrayObject $results,
        array $options
    ) {
        if (!is_callable($helper)) {
            return false;
        }

        $translation->merge($results->getArrayCopy())->getVarTranslation()->translate($options);
        if (!is_array($options)) {
            throw new Exception\LogicException('Expected options of type array');
        }

        $results[$key] = call_user_func_array($helper, $options);
        return true;
    }

    /**
     * Call ZF helper
     *
     * @param string $helper
     * @param mixed $key
     * @param Translation $translation
     * @param ArrayObject $results
     * @param array $options
     * @param bool $joinResult
     * @return self
     */
    protected function callHelper(
        $helper,
        $key,
        Translation $translation,
        ArrayObject $results,
        array $options,
        $joinResult
    ) {
        $plugin = $this->helpers->get($helper);
        foreach ($options as $func => $calls) {
            if (null === $calls) {
                continue;
            }

            foreach ($calls as $params) {
                if (null === $params) {
                    continue;
                }

                $translation->merge($results->getArrayCopy())->getVarTranslation()->translate($params);
                if (!is_array($params)) {
                    throw new Exception\LogicException('Expected params of type array');
                }

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
                    return $this;
                }
            }
        }

        !empty($results[$key]) or
            $results[$key] = null;

        if ($joinResult) {
            $results[$key].= $plugin;
        } else {
            $results[$key] = $plugin;
        }

        return $this;
    }
}
