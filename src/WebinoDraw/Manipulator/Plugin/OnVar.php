<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Stdlib\VarTranslator;

class OnVar  implements InLoopPluginInterface
{
    protected $instructionsRenderer;

    public function __construct(VarTranslator $varTranslator, InstructionsRenderer $instructionsRenderer)
    {
        $this->varTranslator        = $varTranslator;
        $this->instructionsRenderer = $instructionsRenderer;
    }

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
