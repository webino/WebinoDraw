<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use ArrayAccess;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\NodeList;

/**
 *
 */
class DrawTranslate extends DrawElement
{
    /**
     * Return callable to set node value
     *
     * @param array $spec
     * @return Closure
     */
    public function createValuePreSet(array $spec, ArrayAccess $translation)
    {
        $helper = $this;

        return function (
            Element $node,
            $value
        ) use (
            $helper,
            $spec,
            $translation
        ) {
            $textDomain = !empty($spec['text_domain']) ? $spec['text_domain'] : 'default';
            $varValue   = $helper->translatePreSet($node, $value, $spec, clone $translation);

            if (empty($varValue)) {
                return '';
            }
            return $helper->getView()->translate($varValue, $textDomain);
        };
    }

    /**
     * Return callable to set node attributes
     *
     * @param array $spec
     * @return Closure
     */
    public function createAttribsPreSet(array $spec, ArrayAccess $translation)
    {
        $varTranslator = $this->getVarTranslator();
        $helper        = $this;

        return function (
            Element $node,
            $value
        ) use (
            $helper,
            $spec,
            $translation,
            $varTranslator
        ) {
            $textDomain = !empty($spec['text_domain']) ? $spec['text_domain'] : 'default';
            $varValue   = $helper->translatePreSet($node, $value, $spec, clone $translation);

            if (empty($varValue)) {
                return '';
            }
            return $helper->getView()->translate($varValue, $textDomain);
        };
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawPagination
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        return parent::drawNodes($nodes, $spec);
    }
}
