<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\VarTranslator\VarTranslator;

/**
 *
 */
class OnVar implements InLoopPluginInterface
{
    /**
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @var InstructionsRenderer
     */
    protected $instructionsRenderer;

    /**
     * @param VarTranslator $varTranslator
     * @param InstructionsRenderer $instructionsRenderer
     */
    public function __construct(VarTranslator $varTranslator, InstructionsRenderer $instructionsRenderer)
    {
        $this->varTranslator        = $varTranslator;
        $this->instructionsRenderer = $instructionsRenderer;
    }

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['onVar'])) {
            return;
        }

        $this->varTranslator->applyOnVar(
            $arg->getVarTranslation(),
            $spec['onVar'],
            function (array $spec) use ($arg) {

                $this->instructionsRenderer
                    ->expandInstructions($spec)
                    ->subInstructions(
                        $arg->getNodes(),
                        $spec['instructions'],
                        $arg->getTranslation()
                    );
            }
        );
    }
}
