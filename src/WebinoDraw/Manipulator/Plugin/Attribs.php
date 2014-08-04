<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use DOMAttr;
use WebinoDraw\Exception;

/**
 *
 */
class Attribs extends AbstractPlugin implements InLoopPluginInterface
{
    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['attribs'])) {
            return;
        }

        $helper         = $arg->getHelper();
        $node           = $arg->getNode();
        $varTranslation = $arg->getVarTranslation();

        if (!($node instanceof DOMAttr)) {
            throw new Exception\LogicException('Expected node of type DOMAttr');
        }

        foreach ($spec['attribs'] as $attribName => $attribValue) {

            $newAttribValue = $varTranslation->removeVars(
                $helper->translateValue($attribValue, $varTranslation, $spec)
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
