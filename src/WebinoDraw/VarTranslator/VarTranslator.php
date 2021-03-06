<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\VarTranslator;

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
     * Global translation
     *
     * @var Translation
     */
    protected $translation;

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
     * Get global translation
     *
     * @return Translation
     */
    public function getTranslation()
    {
        if (null === $this->translation) {
            $this->setTranslation(new Translation);
        }
        return $this->translation;
    }

    /**
     * Set global translation
     *
     * @param Translation $translation
     * @return $this
     */
    public function setTranslation(Translation $translation)
    {
        $this->translation = $translation;
        return $this;
    }

    /**
     * @param Translation $translation
     * @param array $spec
     * @return $this
     */
    public function apply(Translation $translation, array $spec)
    {
        $translation->merge($this->getTranslation()->getArrayCopy());

        empty($spec['var']['default'])
            or $translation->setDefaults($spec['var']['default']);

        empty($spec['var']['set'])
            or $translation->mergeValues($spec['var']['set']);

        empty($spec['var']['fetch'])
            or $translation->fetchVars($spec['var']['fetch']);

        empty($spec['var']['filter']['pre'])
            or $this->filter->apply($translation, $spec['var']['filter']['pre']);

        empty($spec['var']['helper'])
            or $this->helper->apply($translation, $spec['var']['helper']);

        empty($spec['var']['filter']['post'])
            or $this->filter->apply($translation, $spec['var']['filter']['post']);

        empty($spec['var']['default'])
            or $translation->setDefaults($spec['var']['default']);

        empty($spec['var']['push'])
            or $this->getTranslation()->pushVars($spec['var']['push'], $translation);

        return $this;
    }

    /**
     * Apply variable logic
     *
     * @param Translation $varTranslation
     * @param array $spec
     * @param callable $callback
     * @return $this
     */
    public function applyOnVar(Translation $varTranslation, array $spec, callable $callback)
    {
        $this->onVar->apply($varTranslation, $spec, $callback);
        return $this;
    }

    /**
     * @param array $vars
     * @return Translation
     */
    public function createTranslation(array $vars)
    {
        return new Translation($vars);
    }
}
