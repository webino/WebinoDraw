<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\VarTranslator;

use ArrayAccess;
use WebinoDraw\VarTranslator\Operation\Filter;
use WebinoDraw\VarTranslator\Operation\Helper;
use WebinoDraw\VarTranslator\Operation\OnVar;

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
     * @var Filter
     */
    protected $filter;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var OnVar
     */
    protected $onVar;

    /**
     * @param Filter $filter
     * @param Helper $helper
     * @param OnVar $onVar
     */
    public function __construct(Filter $filter, Helper $helper, OnVar $onVar)
    {
        $this->filter = $filter;
        $this->helper = $helper;
        $this->onVar  = $onVar;
    }

    /**
     * @param ArrayAccess $translation
     * @param array $spec
     * @return self
     */
    public function apply(ArrayAccess $translation, array $spec)
    {
        empty($spec['var']['default']) or
            $translation->setDefaults($spec['var']['default']);

        empty($spec['var']['set']) or
            $translation->mergeValues($spec['var']['set']);

        empty($spec['var']['fetch']) or
            $translation->fetchVars($spec['var']['fetch']);

        empty($spec['var']['filter']['pre']) or
            $this->filter->apply($translation, $spec['var']['filter']['pre']);

        empty($spec['var']['helper']) or
            $this->helper->apply($translation, $spec['var']['helper']);

        empty($spec['var']['filter']['post']) or
            $this->filter->apply($translation, $spec['var']['filter']['post']);

        empty($spec['var']['default']) or
            $translation->setDefaults($spec['var']['default']);

        return $this;
    }

    /**
     * Apply variable logic
     *
     * @param ArrayAccess $varTranslation
     * @param array $spec
     * @param callable $callback
     * @return self
     */
    public function applyOnVar(ArrayAccess $varTranslation, array $spec, callable $callback)
    {
        $this->onVar->apply($varTranslation, $spec, $callback);
        return $this;
    }
}
