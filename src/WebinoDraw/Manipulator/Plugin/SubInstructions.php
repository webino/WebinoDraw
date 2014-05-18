<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Instructions\InstructionsRenderer;

class SubInstructions implements InLoopPluginInterface
{
    protected $instructionsRenderer;

    public function __construct(InstructionsRenderer $instructionsRenderer)
    {
        $this->instructionsRenderer = $instructionsRenderer;
    }

    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        $node = $arg->getNode();
        $this->instructionsRenderer->expandInstructions($spec);
        if (empty($spec['instructions']) || empty($node->ownerDocument)) {
            return;
        }

        $this->instructionsRenderer->subInstructions(
            [$node],
            $spec['instructions'],
            $arg->getTranslation()
        );
    }
}
