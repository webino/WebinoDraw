<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\VarTranslator\VarTranslator;

/**
 *
 */
class VarTranslation implements InLoopPluginInterface
{
    /**
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @param VarTranslator $varTranslator
     */
    public function __construct(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
    }

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $translation = $arg->getTranslation();
        // create variables translation
        $this->varTranslator->apply($translation, $arg->getSpec());
        $arg->setVarTranslation($translation->getVarTranslation());
    }
}
