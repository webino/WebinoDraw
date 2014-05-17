<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\NodeInterface;

/**
 *
 */
class Attribs extends AbstractPlugin implements InLoopPluginInterface
{
    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['attribs'])) {
            return;
        }

        $helper         = $arg->getHelper();
        $varTranslation = $arg->getVarTranslation();

        foreach ($spec['attribs'] as $attribName => $attribValue) {

            $newAttribValue = $varTranslation->removeVars(
                $helper->translateValue($attribValue, $varTranslation)
            );

            if (empty($newAttribValue) && !is_numeric($newAttribValue)) {
                $node->removeAttribute($attribName);
            } else {
                $node->setAttribute($attribName, trim($newAttribValue));
            }
        }

        $this->updateNodeVarTranslation($node, $arg);
    }
}
