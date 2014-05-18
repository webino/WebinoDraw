<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Stdlib\VarTranslator;

class VarTranslation implements InLoopPluginInterface
{

    protected $varTranslator;

    public function __construct(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
    }


    public function inLoop(PluginArgument $arg)
    {
        $translation = $arg->getTranslation();
        // create variables translation
        $this->varTranslator->apply($translation, $arg->getSpec());
        $arg->setVarTranslation($translation->getVarTranslation());
    }
}
