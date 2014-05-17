<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\NodeInterface;

class NodeTranslation implements InLoopPluginInterface
{
    protected $lastNodeTranslation = [];

    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
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
