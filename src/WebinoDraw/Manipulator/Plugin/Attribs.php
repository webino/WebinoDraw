<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use DOMElement;
use WebinoDraw\Exception;

/**
 * Class Attribs
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

        if (!($node instanceof DOMElement)) {
            throw new Exception\LogicException('Expected node of type DOMAttr');
        }

        foreach ($spec['attribs'] as $attribName => $attribValue) {
            if (empty($node->parentNode)) {
                // node no longer exists
                continue;
            }
            
            $newAttribValue = $varTranslation->removeVars(
                $helper->translateValue($attribValue, $varTranslation, $spec)
            );

            $varKey = $varTranslation->makeVar($varTranslation->makeExtraVarKey($attribName));

            if (empty($newAttribValue) && !is_numeric($newAttribValue)) {
                $node->removeAttribute($attribName);
                $varTranslation->offsetExists($varKey) and $varTranslation->offsetUnset($varKey);
            } else {
                $newAttribValue = trim($newAttribValue);
                $node->setAttribute($attribName, $newAttribValue);
                $varTranslation->offsetSet($varKey, $newAttribValue);
            }
        }
    }
}
