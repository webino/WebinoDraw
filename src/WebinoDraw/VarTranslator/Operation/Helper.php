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

use ArrayAccess;
use ArrayObject;
use Zend\View\HelperPluginManager;
use Zend\View\Helper\HelperInterface;

/**
 *
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
     * Apply view helpers and functions on variables
     *
     * Call user function if exists else call helper
     *
     * @todo refactor
     * @param ArrayAccess $translation Variables with values to modify
     * @param array $spec Helper options
     * @return self
     */
    public function apply(ArrayAccess $translation, array $spec)
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

                    $translation->merge($results->getArrayCopy())->getVarTranslation()->translate($options);

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

                            $translation->merge($results->getArrayCopy())->getVarTranslation()->translate($params);

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
}
