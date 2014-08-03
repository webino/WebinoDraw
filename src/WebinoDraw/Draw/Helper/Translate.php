<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper;

use ArrayAccess;
use DOMAttr as Attrib;
use WebinoDraw\Dom\NodeList;
use Zend\I18n\Translator\TranslatorInterface;

/**
 *
 */
class Translate extends Element
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param NodeList $nodes
     * @return self
     */
    public function drawNodes(NodeList $nodes)
    {
        $spec        = $this->getSpec();
        $remainNodes = $this->translateAttribNodes($nodes, $this->resolveTextDomain($spec));

        if (empty($remainNodes)) {
            // return early when all nodes were attribs
            return $this;
        }

        return parent::drawNodes($nodes->create($remainNodes));
    }

    /**
     * @param string $value
     * @param ArrayAccess $varTranslation
     * @return string
     */
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
            if ($node instanceof Attrib && !$node->isEmpty()) {
                $node->nodeValue = $this->translator->translate($node->nodeValue, $textDomain);
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
