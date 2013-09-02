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
use DOMAttr;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\NodeList;
use Zend\View\Renderer\PhpRenderer;

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
        $textDomain = $this->resolveTextDomain($spec);
        $view       = $this->getView();
        $helper     = $this;

        return function (
            Element $node,
            $value
        ) use (
            $helper,
            $spec,
            $translation,
            $textDomain,
            $view
        ) {
            $varValue = $helper->translatePreSet($node, $value, $spec, clone $translation);
            if (empty($varValue)) {
                return '';
            }
            return $view->translate($varValue, $textDomain);
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
        $textDomain = $this->resolveTextDomain($spec);
        $view       = $this->getView();
        $helper     = $this;

        return function (
            Element $node,
            $value
        ) use (
            $helper,
            $spec,
            $translation,
            $textDomain,
            $view
        ) {
            $varValue = $helper->translatePreSet($node, $value, $spec, clone $translation);
            if (empty($varValue)) {
                return '';
            }
            return $view->translate($varValue, $textDomain);
        };
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawPagination
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $textDomain  = $this->resolveTextDomain($spec);
        $view        = $this->getView();
        $remainNodes = $this->translateAttribNodes($nodes, $view, $textDomain);

        if (empty($remainNodes)) {
            // return early when all nodes were attribs
            return $this;
        }

        return parent::drawNodes($nodes->createNodeList($remainNodes), $spec);
    }

    /**
     * @param NodeList $nodes
     * @param PhpRenderer $view
     * @param string $textDomain
     * @return \DOMAttr
     */
    protected function translateAttribNodes(NodeList $nodes, PhpRenderer $view, $textDomain)
    {
        $remainNodes = array();
        foreach ($nodes as $node) {
            if ($node instanceof DOMAttr) {
                $node->nodeValue = $view->translate($node->nodeValue, $textDomain);
                continue;
            }
            $remainNodes[] = $node;
        }

        return $remainNodes;
    }

    /**
     * @param array $spec
     * @return bool
     */
    protected function resolveTextDomain(array $spec)
    {
        return !empty($spec['text_domain']) ? $spec['text_domain'] : 'default';
    }
}
