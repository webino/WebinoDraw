<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\NodeInterface;

interface InLoopPluginInterface extends PluginInterface
{
    public function inLoop(NodeInterface $node, PluginArgument $arg);
}
