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
use DOMNode;
use WebinoDraw\Dom\Element;

/**
 *
 */
abstract class AbstractDrawElement extends AbstractDrawHelper
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
            return $helper->translatePreSet($node, $value, $spec, clone $translation);
        };
    }

    /**
     * Return callable to set node HTML value
     *
     * @param string $subject
     * @param array $spec
     * @return Closure
     */
    public function createHtmlPreSet($subject, array $spec, ArrayAccess $translation)
    {
        $varTranslator = $this->getVarTranslator();
        $helper        = $this;
        $innerHtmlKey  = self::EXTRA_VAR_PREFIX . 'innerHtml';
        $outerHtmlKey  = self::EXTRA_VAR_PREFIX . 'outerHtml';

        return function (
            Element $node,
            $value,
            $nodes
        ) use (
            $helper,
            $subject,
            $spec,
            $varTranslator,
            $translation,
            $innerHtmlKey,
            $outerHtmlKey
        ) {
            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            // include node innerHTML to the translation
            (false === strpos($subject, $innerHtmlKey)) or
                $nodeTranslation[$innerHtmlKey] = $node->getInnerHtml();

            // include node outerHTML to the translation
            (false === strpos($subject, $outerHtmlKey)) or
                $nodeTranslation[$outerHtmlKey] = $node->getOuterHtml();

            $translatedValue = $varTranslator->translateString(
                $value,
                $varTranslator->makeVarKeys($translation)
            );

            $nodeTranslatedValue = $varTranslator->translateString(
                $translatedValue,
                $varTranslator->makeVarKeys($nodeTranslation)
            );

            if (empty($nodeTranslatedValue)
                && array_key_exists('onEmpty', $spec)
            ) {
                $helper->manipulateNodes($nodes, $spec['onEmpty'], $translation);
                return '';
            }

            return $nodeTranslatedValue;
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
        $helper = $this;

        return function (
            Element $node,
            $value
        ) use (
            $helper,
            $spec,
            $translation
        ) {
            return $helper->translatePreSet($node, $value, $spec, clone $translation);
        };
    }

    /**
     * @param DOMNode $node
     * @param string $value
     * @param array $spec
     * @param ArrayAccess $translation
     * @return type
     */
    public function translatePreSet(DOMNode $node, $value, array &$spec, ArrayAccess $translation)
    {
        $varTranslator   = $this->getVarTranslator();
        $nodeTranslation = $this->nodeTranslation($node);

        empty($spec['var']['default']) or
            $varTranslator->translationDefaults(
                $nodeTranslation,
                $spec['var']['default']
            );

        $this->applyVarTranslator($nodeTranslation, $spec);

        $translation->merge(
            $nodeTranslation->getArrayCopy()
        );

        $varTranslator->translate(
            $spec,
            $varTranslator->makeVarKeys($translation)
        );

        $this->applyVarTranslator($translation, $spec);

        $translatedValue = $varTranslator->translateString(
            $value,
            $varTranslator->makeVarKeys($translation)
        );

        if ($varTranslator->containsVar($translatedValue)) {
            return $varTranslator->removeVars($translatedValue);
        }
        return $translatedValue;
    }
}
