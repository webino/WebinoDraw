<?php

namespace WebinoDraw\Manipulator\Plugin;

interface PostLoopPluginInterface extends PluginInterface
{
    public function postLoop(PluginArgument $arg);
}
