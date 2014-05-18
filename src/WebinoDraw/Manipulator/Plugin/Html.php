<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Stdlib\VarTranslator;

class Html implements InLoopPluginInterface
{
    protected $varTranslator;
    protected $instructionsRenderer;

    public function __construct(VarTranslator $varTranslator, InstructionsRenderer $instructionsRenderer)
    {
        $this->varTranslator        = $varTranslator;
        $this->instructionsRenderer = $instructionsRenderer;
    }

    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('html', $spec)
            || null === $spec['html']
        ) {
            return;
        }

        $translatedHtml  = $arg->getHelper()->translateValue($spec['html'], $arg->getVarTranslation());
        $node = $arg->getNode();
        $node->nodeValue = '';

        if (empty($translatedHtml)) {
            return;
        }

        $frag = $node->ownerDocument->createDocumentFragment();
        $frag->appendXml($translatedHtml);
        if (!$frag->hasChildNodes()) {
            throw new \RuntimeException('Invalid XHTML ' . $translatedHtml);
        }
        $node->appendChild($frag);
    }
}
