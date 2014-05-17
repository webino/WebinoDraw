<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Stdlib\VarTranslator;
use WebinoDraw\Dom\NodeInterface;

class VarTranslation implements InLoopPluginInterface
{

    protected $varTranslator;

    public function __construct(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
    }


    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $translation = $arg->getTranslation();
        // create variables translation
        $this->varTranslator->apply($translation, $arg->getSpec());
        $arg->setVarTranslation($translation->getVarTranslation());
    }
}
