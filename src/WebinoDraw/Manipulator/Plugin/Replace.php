<?php

namespace WebinoDraw\Manipulator\Plugin;

class Replace extends AbstractPlugin implements
    InLoopPluginInterface,
    PostLoopPluginInterface
{
    protected $nodesToRemove = [];

    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('replace', $spec)
            || null === $spec['replace']
        ) {
            return;
        }

        $varTranslation = $arg->getVarTranslation();
        $translatedHtml = $arg->getHelper()->translateValue($spec['replace'], $varTranslation);
        $node = $arg->getNode();
        $node->nodeValue = '';

        if (!empty($translatedHtml)) {
            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($translatedHtml);

            // insert new node remove old later
            $newNode = $node->parentNode->insertBefore($frag, $node);
            $arg->setNode($newNode);
            $this->nodesToRemove[] = $node;
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
