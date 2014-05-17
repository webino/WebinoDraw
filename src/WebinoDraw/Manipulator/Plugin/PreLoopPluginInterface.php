<?php

namespace WebinoDraw\Manipulator\Plugin;

interface PreLoopPluginInterface extends PluginInterface
{
    public function preLoop(PluginArgument $arg);
}
