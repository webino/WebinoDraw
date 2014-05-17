<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\NodeInterface;

class Replace extends AbstractPlugin implements
    InLoopPluginInterface,
    PostLoopPluginInterface
{
    protected $nodesToRemove = [];

    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('replace', $spec)
            || null === $spec['replace']
        ) {
            return;
        }

        $varTranslation  = $arg->getVarTranslation();
        $translatedHtml  = $arg->getHelper()->translateValue($spec['replace'], $varTranslation);
        $node->nodeValue = '';

        if (!empty($translatedHtml)) {
            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($translatedHtml);

            $newNode = $node->parentNode->insertBefore($frag, $node);
            $this->nodesToRemove[] = $node;
            $node = $newNode;
        }

        $this->updateNodeVarTranslation($node, $arg);
    }

    public function postLoop(PluginArgument $arg)
    {
        foreach ($this->nodesToRemove as $node) {
            empty($node->parentNode) or
                $node->parentNode->removeChild($node);
        }
    }
}
