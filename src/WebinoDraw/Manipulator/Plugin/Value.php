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

use DOMNode;
use WebinoDraw\Dom\Element;
use WebinoDraw\Exception;
use WebinoDraw\View\Helper\EscapeHtmlTrait;

/**
 * Class Value
 */
class Value extends AbstractPlugin implements InLoopPluginInterface
{
    use EscapeHtmlTrait;

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('value', $spec) || null === $spec['value']) {
            return;
        }

        $node = $arg->getNode();
        if (!($node instanceof DOMNode)) {
            throw new Exception\LogicException('Expected node of type ' . DOMNode::class);
        }

        $varTranslation  = $arg->getVarTranslation();
        $translatedValue = $arg->getHelper()->translateValue($spec['value'], $varTranslation, $spec);
        $escapeHtml      = $this->getEscapeHtml();
        $node->nodeValue = $escapeHtml->__invoke($varTranslation->removeVars($translatedValue));

        $varKey = $varTranslation->makeVar($varTranslation->makeExtraVarKey($node::NODE_VALUE_PROPERTY));
        $varTranslation->offsetSet($varKey, $node->nodeValue);

        ($node instanceof Element)
            and $varTranslation->merge(
                $this->createNodeHtmlTranslation($node, $spec)->getVarTranslation()->getArrayCopy()
            );
    }
}
