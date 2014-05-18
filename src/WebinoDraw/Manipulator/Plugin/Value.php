<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Element;
use Zend\View\Helper\EscapeHtml;

class Value extends AbstractPlugin implements InLoopPluginInterface
{
    protected $escapeHtml;

    public function __construct(EscapeHtml $escapeHtml)
    {
        $this->escapeHtml = $escapeHtml;
    }

    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        $node = $arg->getNode();
        
        if (!($node instanceof Element)
            || !array_key_exists('value', $spec)
            || null === $spec['value']
        ) {
            return;
        }

        $varTranslation  = $arg->getVarTranslation();
        $translatedValue = $arg->getHelper()->translateValue($spec['value'], $varTranslation);
        $node->nodeValue = $this->escapeHtml->__invoke($varTranslation->removeVars($translatedValue));

        $this->updateNodeVarTranslation($node, $arg);
    }
}
