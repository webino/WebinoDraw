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
    public function createValuePreSet(array $spec)
    {
        $translation   = clone $this->getTranslationPrototype();
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

            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            $helper->applyVarTranslator($nodeTranslation, $spec);

            $translation->merge(
                $varTranslator
                    ->makeVarKeys($nodeTranslation)
                    ->getArrayCopy()
            );

            return $varTranslator->translateString($value, $translation);
        };
    }

    /**
     * Return callable to set node HTML value
     *
     * @param string $subject
     * @param array $spec
     * @return Closure
     */
    public function createHtmlPreSet($subject, array $spec)
    {
        $translation   = clone $this->getTranslationPrototype();
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

            $helper->applyVarTranslator($nodeTranslation, $spec);

            $translation->merge(
                $varTranslator
                    ->makeVarKeys($nodeTranslation)
                    ->getArrayCopy()
            );

            return $varTranslator->translateString($value, $translation);
        };
    }

    /**
     * Return callable to set node attributes
     *
     * @param array $spec
     * @return Closure
     */
    public function createAttribsPreSet(array $spec)
    {
        $translation   = clone $this->getTranslationPrototype();
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
            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            $helper->applyVarTranslator($nodeTranslation, $spec);

            $translation->merge(
                $varTranslator
                    ->makeVarKeys($nodeTranslation)
                    ->getArrayCopy()
            );

            $value = $varTranslator->translateString($value, $translation);

            if ($varTranslator->containsVar($value)) {
                $value = null;
            }

            return $value;
        };
    }
}
