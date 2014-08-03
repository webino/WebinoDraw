<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Helper;

use ArrayAccess;
use DOMAttr;
use WebinoDraw\Dom\NodeList;
use Zend\View\Renderer\PhpRenderer;

/**
 *
 */
class DrawTranslate extends DrawElement
{
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

    protected function translateValue($value, ArrayAccess $varTranslation, array $spec)
    {
        $varValue = trim(parent::translateValue($value, $varTranslation, $spec));
        if (empty($varValue)) {
            return '';
        }

        return $this->getView()->translate($varValue, $this->resolveTextDomain($spec));
    }

    /**
     * @param NodeList $nodes
     * @param PhpRenderer $view
     * @param string $textDomain
     * @return \DOMAttr
     */
    protected function translateAttribNodes(NodeList $nodes, PhpRenderer $view, $textDomain)
    {
        $remainNodes = [];
        foreach ($nodes as $node) {
            if ($node instanceof DOMAttr) {
                $nodeValue = trim($node->nodeValue);

                empty($nodeValue) or
                    $node->nodeValue = $view->translate($nodeValue, $textDomain);

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
