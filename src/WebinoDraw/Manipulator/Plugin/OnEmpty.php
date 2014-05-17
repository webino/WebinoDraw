<?php

namespace WebinoDraw\Manipulator\Plugin;

use DOMText as DomText;
use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\Instructions\InstructionsRenderer;

/**
 *
 */
class OnEmpty implements InLoopPluginInterface
{
    protected $instructionsRenderer;

    public function __construct(InstructionsRenderer $instructionsRenderer)
    {
        $this->instructionsRenderer = $instructionsRenderer;
    }

    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['onEmpty'])) {
            return;
        }

        if (($node instanceof NodeInterface && !$node->isEmpty())
            || ($node instanceof DomText && '' !== trim($node->nodeValue))
        ) {
            return;
        }

        $onEmptySpec = $spec['onEmpty'];
        $nodes       = $arg->getNodes();
        $translation = $arg->getTranslation();

        if (!empty($onEmptySpec['locator'])) {
            $this->instructionsRenderer->subInstructions($nodes, [$onEmptySpec], $translation);
            return;
        }

        $arg->getHelper()->manipulateNodes($nodes, $onEmptySpec, $translation);

        $this->instructionsRenderer->expandInstructions($onEmptySpec);
        empty($onEmptySpec['instructions']) or
            $this->instructionsRenderer->subInstructions(
                $nodes,
                $onEmptySpec['instructions'],
                $translation
            );
    }
}
