<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Element;

class NodeTranslation implements InLoopPluginInterface
{
    protected $lastNodeTranslation = [];

    public function inLoop(PluginArgument $arg)
    {
        $node = $arg->getNode();
        if (!$node instanceof Element) {
            return;
        }

        $translation = $arg->getTranslation();
        // unset the last node translation then merge current one
        $nodeTranslation = $translation->createNodeTranslation($node, $arg->getSpec());
        $translation->unsetKeys(array_keys($this->lastNodeTranslation));
        $this->lastNodeTranslation = $nodeTranslation->getArrayCopy();
        $translation->merge($this->lastNodeTranslation);
    }
}
