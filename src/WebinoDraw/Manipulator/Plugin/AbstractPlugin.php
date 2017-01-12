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

use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\VarTranslator\Translation;

/**
 *
 */
abstract class AbstractPlugin
{
    /**
     * @param NodeInterface $node
     * @param PluginArgument $arg
     * @return self
     */
    protected function updateNodeVarTranslation(NodeInterface $node, PluginArgument $arg)
    {
        $arg->getVarTranslation()->merge($this->createNodeVarTranslationArray($node, $arg->getSpec()));
        return $this;
    }

    /**
     * @param NodeInterface $node
     * @param array $spec
     * @return array
     */
    public function createNodeVarTranslationArray(NodeInterface $node, array $spec)
    {
        return $this->createNodeTranslation($node, $spec)->getVarTranslation()->getArrayCopy();
    }

    /**
     * @param NodeInterface $node
     * @param array $spec
     * @return Translation
     */
    public function createNodeTranslation(NodeInterface $node, array $spec)
    {
        $translation = new Translation($node->getProperties(Translation::EXTRA_VAR_PREFIX));
        if (!($node instanceof Element)) {
            return $translation;
        }

        $htmlTranslation = $this->createNodeHtmlTranslation($node, $spec);
        $translation->merge($htmlTranslation->getArrayCopy());
        return $translation;
    }

    /**
     * @param Element $node
     * @param array $spec
     * @return Translation
     */
    public function createNodeHtmlTranslation(Element $node, array $spec)
    {
        $translation  = new Translation;
        $innerHtmlKey = $translation->makeExtraVarKey('innerHtml');
        $outerHtmlKey = $translation->makeExtraVarKey('outerHtml');

        foreach (['html', 'replace'] as $key) {
            if (empty($spec[$key])) {
                continue;
            }

            if (false !== strpos($spec[$key], $innerHtmlKey)) {
                $translation[$innerHtmlKey] = $node->getInnerHtml();
            }

            if (false !== strpos($spec[$key], $outerHtmlKey)) {
                $translation[$outerHtmlKey] = $node->getOuterHtml();
            }
        }

        return $translation;
    }
}
