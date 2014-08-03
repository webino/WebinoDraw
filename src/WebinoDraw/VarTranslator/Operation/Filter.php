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
use Zend\Filter\FilterPluginManager;

class Filter
{
    /**
     * @var FilterPluginManager
     */
    protected $filters;

    /**
     * @param FilterPluginManager $filters
     */
    public function __construct(FilterPluginManager $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Apply filters and functions on variables
     *
     * Call user function if exists else call filter.
     *
     * @todo refactor
     * @param ArrayAccess $translation Variables with values to modify
     * @param array $spec Filter options
     * @return self
     */
    public function apply(ArrayAccess $translation, array $spec)
    {
        foreach ($spec as $key => $subSpec) {
            if (!array_key_exists($key, $translation)) {
                // skip undefined
                continue;
            }

            foreach ((array) $subSpec as $helper => $options) {
                if (function_exists($helper)) {
                    // php functions first
                    $translation->getVarTranslation()->translate($options);
                    $translation[$key] = call_user_func_array($helper, $options);

                } else {
                    // zf filter
                    $translation->getVarTranslation()->translate($options);

                    if (empty($options[0])) {
                        $translation[$key] = '';
                        continue;
                    }

                    !empty($options[1]) or
                        $options[1] = [];

                    $translation[$key] = $this->filters->get($helper, $options[1])->filter($options[0]);
                }
            }
        }

        return $this;
    }
}
