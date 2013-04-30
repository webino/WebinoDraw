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

use DOMElement;

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
            DOMElement $node,
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

        return function (
            DOMElement $node,
            $value
        ) use (
            $helper,
            $subject,
            $spec,
            $varTranslator,
            $translation
        ) {
            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            if (false !== strpos($subject, 'html')) {

                if ($node->childNodes->length
                  || !array_key_exists('html', $translation)
                ) {
                    $nodeTranslation['html'] = null;
                }

                foreach ($node->childNodes as $child) {
                    $html = trim($child->ownerDocument->saveXML($child));
                    empty($html) or $nodeTranslation['html'].= $html;
                }
            }

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
            DOMElement $node,
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
