<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Dom\NodeInterface;

/**
 *
 */
class Cdata implements InLoopPluginInterface
{
    protected $instructionsRenderer;

    public function __construct(InstructionsRenderer $instructionsRenderer)
    {
        $this->instructionsRenderer = $instructionsRenderer;
    }

    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('cdata', $spec)
            || null === $spec['cdata']
        ) {
            return;
        }

        $node->nodeValue = '';
        $translatedCdata = $arg->getHelper()->translateValue($spec['cdata'], $arg->getVarTranslation());

        if (empty($translatedCdata)) {
            return;
        }

        $cdata = $node->ownerDocument->createCdataSection($translatedCdata);
        $node->appendChild($cdata);
    }
}
