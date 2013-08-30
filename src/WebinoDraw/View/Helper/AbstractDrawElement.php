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
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Stdlib\VarTranslator;

/**
 *
 */
abstract class AbstractDrawElement extends AbstractDrawHelper
{
    /**
     * Manipulate nodes
     *
     * @todo protected PHP 5.4
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return bool
     */
    public function manipulateNodes(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        $translatedSpec = $this->translateSpec($spec, $translation);

        empty($spec['render']) or
            $this->render($translation, $spec['render']);

        !array_key_exists('remove', $translatedSpec) or
            $nodes->remove($translatedSpec['remove']);

        if (array_key_exists('replace', $spec)) {
            $this->replace($nodes, $spec, $translation);
            return false;
        }

        !array_key_exists('attribs', $spec) or
            $this->setAttribs($nodes, $spec, $translation);

        !array_key_exists('value', $spec) or
            $this->setValue($nodes, $spec, $translation);

        !array_key_exists('html', $spec) or
            $this->setHtml($nodes, $spec, $translation);

        if (array_key_exists('onEmpty', $translatedSpec)) {

            $onEmptySpec = $translatedSpec['onEmpty'];
            $this->onEmpty($nodes, $onEmptySpec);

            empty($onEmptySpec['instructions']) or
                $this->subInstructions($nodes, $onEmptySpec['instructions'], $translation);
        }

        return true;
    }

    /**
     * @param NodeList $nodes
     * @param array $instructions
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    protected function subInstructions(NodeList $nodes, array $instructions, ArrayAccess $translation)
    {
        foreach ($nodes as $node) {

            $this
                ->cloneInstructionsPrototype($instructions)
                ->render(
                   $node,
                   $this->view,
                   $translation->getArrayCopy()
               );
        }

        return $this;
    }

    /**
     * Return callable to set node value
     *
     * @param array $spec
     * @return Closure
     */
    public function createValuePreSet(array $spec, ArrayAccess $translation)
    {
        $helper = $this; // todo PHP 5.4

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
        $helper        = $this; // todo PHP 5.4
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

            $helper->applyDefault($spec, $varTranslator, $nodeTranslation);

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
        $helper = $this; // todo PHP 5.4

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

        $this->applyDefault($spec, $varTranslator, $nodeTranslation);

        $translation->merge(
            $nodeTranslation->getArrayCopy()
        );

        $this->applyVarTranslator($translation, $spec);

        $varTranslator->translate(
            $spec,
            $varTranslator->makeVarKeys($translation)
        );

        $this->applyVarTranslator($translation, $spec);

        $this->applyDefault($spec, $varTranslator, $translation);

        $translatedValue = $varTranslator->translateString(
            $value,
            $varTranslator->makeVarKeys($translation)
        );

        if ($varTranslator->containsVar($translatedValue)) {
            return $varTranslator->removeVars($translatedValue);
        }

        return $translatedValue;
    }

    public function applyDefault(array $spec, VarTranslator $varTranslator, ArrayAccess $translation)
    {
        empty($spec['var']['default']) or
            $varTranslator->translationDefaults(
                $translation,
                $spec['var']['default']
            );

        return $this;
    }
}
