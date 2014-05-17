<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\Instructions\InstructionsRenderer;

class SubInstructions implements InLoopPluginInterface
{
    protected $instructionsRenderer;

    public function __construct(InstructionsRenderer $instructionsRenderer)
    {
        $this->instructionsRenderer = $instructionsRenderer;
    }

    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
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
