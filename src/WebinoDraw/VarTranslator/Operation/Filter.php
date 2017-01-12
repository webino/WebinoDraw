<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\VarTranslator\Operation;

use WebinoDraw\Exception;
use WebinoDraw\VarTranslator\Translation;
use Zend\Filter\FilterPluginManager;

/**
 *
 */
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
     * Apply functions and filters on variables
     *
     * Call function if exists else call filter.
     *
     * @param Translation $translation Variables with values to modify
     * @param array $spec Filter options
     * @return self
     */
    public function apply(Translation $translation, array $spec)
    {
        foreach ($spec as $key => $subSpec) {
            if ($translation->offsetExists($key)) {
                $this->iterateFilterSpec((array) $subSpec, $key, $translation);
            }
        }

        return $this;
    }

    /**
     * @param array $spec
     * @param mixed $key
     * @param Translation $translation
     * @return self
     * @throws Exception\InvalidInstructionException
     */
    protected function iterateFilterSpec(array $spec, $key, Translation $translation)
    {
        foreach ($spec as $filter => $options) {
            $translation->getVarTranslation()->translate($options);
            if (!is_array($options)) {
                throw new Exception\InvalidInstructionException(
                    'Expected array options for spec ' . print_r($spec, true)
                );
            }

            if (is_callable($filter)) {
                $translation[$key] = call_user_func_array($filter, $options);
                continue;
            }

            $this->callFilter($filter, $key, $translation, $options);
        }

        return $this;
    }

    /**
     * Call ZF filter
     *
     * @param string $filter
     * @param mixed $key
     * @param Translation $translation
     * @param array $options
     * @return self
     */
    protected function callFilter($filter, $key, Translation $translation, array $options)
    {
        if (empty($options[0])) {
            $translation[$key] = '';
            return $this;
        }

        !empty($options[1]) or
            $options[1] = [];

        $translation[$key] = $this->filters->get($filter, $options[1])->filter($options[0]);
        return $this;
    }
}
