<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Helper;

use ArrayAccess;
use DOMAttr;
use WebinoDraw\Dom\NodeList;
use Zend\I18n\Translator\TranslatorInterface;

/**
 *
 */
class DrawTranslate extends DrawElement
{
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return self
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $remainNodes = $this->translateAttribNodes($nodes, $this->resolveTextDomain($spec));
        if (empty($remainNodes)) {
            // return early when all nodes were attribs
            return $this;
        }

        return parent::drawNodes($nodes->create($remainNodes), $spec);
    }

    public function translateValue($value, ArrayAccess $varTranslation)
    {
        $varValue = trim(parent::translateValue($value, $varTranslation));
        if (empty($varValue)) {
            return '';
        }

        return $this->translator->translate($varValue, $this->resolveTextDomain($this->getSpec()));
    }

    /**
     * @param NodeList $nodes
     * @param string $textDomain
     * @return array
     */
    protected function translateAttribNodes(NodeList $nodes, $textDomain)
    {
        $remainNodes = [];
        foreach ($nodes as $node) {
            if ($node instanceof DOMAttr) {

                $nodeValue = trim($node->nodeValue);
                if (empty($nodeValue)) {
                    continue;
                }

                $node->nodeValue = $this->translator->translate($nodeValue, $textDomain);
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
        // TODO inversion of control (spec object)
        return !empty($spec['text_domain']) ? $spec['text_domain'] : 'default';
    }
}
