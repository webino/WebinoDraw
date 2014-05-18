<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Instructions\InstructionsRenderer;

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

    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('cdata', $spec)
            || null === $spec['cdata']
        ) {
            return;
        }

        $node = $arg->getNode();
        $node->nodeValue = '';
        $translatedCdata = $arg->getHelper()->translateValue($spec['cdata'], $arg->getVarTranslation());

        if (empty($translatedCdata)) {
            return;
        }

        $node->appendChild(
            $node->ownerDocument->createCdataSection($translatedCdata)
        );
    }
}
