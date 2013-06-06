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
            return $helper->translatePreSet($node, $value, $spec, $translation);
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
        $nodeHtmlKey   = self::EXTRA_VAR_PREFIX . 'html';

        return function (
            Element $node,
            $value
        ) use (
            $helper,
            $subject,
            $spec,
            $varTranslator,
            $translation,
            $nodeHtmlKey
        ) {
            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            // include node innerHTML to the translation
            (false === strpos($subject, $nodeHtmlKey)) or
                $nodeTranslation[$nodeHtmlKey] = $node->getInnerHtml();

            $translatedValue = $varTranslator->translateString(
                $value,
                $varTranslator->makeVarKeys($translation)
            );

            return $varTranslator->translateString(
                $translatedValue,
                $varTranslator->makeVarKeys($nodeTranslation)
            );
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
            $translatedValue = $helper->translatePreSet($node, $value, $spec, $translation);

            if ($varTranslator->containsVar($translatedValue)) {
                return $varTranslator->removeVars($translatedValue);
            }
            return $translatedValue;
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

        return $translatedValue;
    }
}
