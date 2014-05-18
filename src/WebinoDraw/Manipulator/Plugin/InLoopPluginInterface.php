<?php

namespace WebinoDraw\Manipulator\Plugin;

interface InLoopPluginInterface extends PluginInterface
{
    public function inLoop(PluginArgument $arg);
}
