<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Element;

/**
 *
 */
abstract class AbstractPlugin
{
    /**
     * @param Element $node
     * @param PluginArgument $arg
     * @return self
     */
    protected function updateNodeVarTranslation(Element $node, PluginArgument $arg)
    {
        $arg->getVarTranslation()->merge(
            $arg->getTranslation()->createNodeVarTranslationArray($node, $arg->getSpec())
        );
        return $this;
    }
}
