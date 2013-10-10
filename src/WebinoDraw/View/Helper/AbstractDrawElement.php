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
     * @param NodeList $nodes
     * @param array $spec
     * @return AbstractDrawElement
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $translation = $this->cloneTranslationPrototype($this->getVars());

        if (!empty($spec['loop'])) {
            $this->loop($nodes, $spec, $translation);

        } elseif (!$this->manipulateNodes($nodes, $spec, $translation)) {
            return $this;
        }

        empty($spec['instructions']) or
            $this->subInstructions($nodes, $spec['instructions'], $translation);

        return $this;
    }

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

        !array_key_exists('onVar', $translatedSpec) or
            $this->onVar($nodes, $translatedSpec['onVar'], $translation);

        !array_key_exists('onEmpty', $translatedSpec) or
            $this->onEmpty($nodes, $translatedSpec['onEmpty']);

        return true;
    }

    /**
     * Render view script to {$var}
     *
     * @param ArrayAccess $translation
     * @param array $options
     * @return AbstractDrawElement
     */
    protected function render(ArrayAccess $translation, array $options)
    {
        foreach ($options as $key => $value) {
            $translation[$key] = $this->view->render($value);
        }

        return $this;
    }

    /**
     * Replace nodes with XHTML
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    protected function replace(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        if (!empty($spec['locator'])) {

            $locator = $nodes->getLocator();

            foreach ($nodes as $node) {
                if (empty($node->ownerDocument)) {
                    // node no longer exists
                    continue;
                }

                // TODO BC break match relative to the node
                $newNodes = $node->ownerDocument->xpath->query(
                    $locator->set($spec['locator'])->xpathMatchAny()
                );

                $subspec = $spec;
                unset($subspec['locator']);
                $this->replace(
                    $nodes->createNodeList($newNodes),
                    $subspec,
                    $translation
                );
            }

            return $this;
        }

        $nodes->replace(
            $spec['replace'],
            $this->createHtmlPreSet($spec['replace'], $spec, $translation)
        );

        // redraw
        $subspec = $spec;
        unset($subspec['replace']);
        self::drawNodes($nodes, $subspec);

        return $this;
    }

    /**
     * Set attributes for each node in the list
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    protected function setAttribs(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        $nodes->setAttribs(
            $spec['attribs'],
            $this->createAttribsPreSet($spec, $translation)
        );
        return $this;
    }

    /**
     * Set text value for each node in the list
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    protected function setValue(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        $nodes->setValue(
            $spec['value'],
            $this->createValuePreSet($spec, $translation)
        );
        return $this;
    }

    /**
     * Set XHTML for each node in the list
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    protected function setHtml(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        if (empty($spec['html'])) {
            return $this;
        }

        $nodes->setHtml(
            $spec['html'],
            $this->createHtmlPreSet($spec['html'], $spec, $translation)
        );
        return $this;
    }

    /**
     * Support for the variables logic
     *
     * Allows to draw instructions based on the variable logic.
     * Currently only equalTo and notEqualTo supported.
     *
     * @todo Add support for the: lessThan, greaterThan, lessThanOrEqualTo, greaterThanOrEqualTo, match, in, between
     * @todo Decouple to its own class with related private methods
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     * @throws Exception\InvalidInstructionException
     */
    protected function onVar(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        foreach ($spec as $subSpec) {
            if (!array_key_exists('var', $subSpec)) {
                throw new Exception\InvalidInstructionException(
                    'Expected `var` option in ' . print_r($subSpec, true)
                );
            }

            !array_key_exists('equalTo', $subSpec) or
                $this->onVarEqualTo($nodes, $subSpec, $translation);

            !array_key_exists('notEqualTo', $subSpec) or
                $this->onVarNotEqualTo($nodes, $subSpec, $translation);
        }

        return $this;
    }

    /**
     * Handle onVar() equalTo
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    private function onVarEqualTo(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        if ($spec['var'] !== $spec['equalTo']) {
            return $this;
        }

        $this->subInstructions($nodes, $spec['instructions'], $translation);
        return $this;
    }

    /**
     * Handle onVar() notEqualTo
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
    private function onVarNotEqualTo(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        if ($spec['var'] === $spec['notEqualTo']) {
            return $this;
        }

        $this->subInstructions($nodes, $spec['instructions'], $translation);
        return $this;
    }

    /**
     * If node has no text value, draw it with onEmpty options
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return AbstractDrawElement
     */
    protected function onEmpty(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {

            $nodeValue = trim($node->nodeValue);

            if (!empty($nodeValue)
                || is_numeric($nodeValue)
            ) {
                continue;
            }

            // node value is empty,
            // chceck for childs other than text
            foreach ($node->childNodes as $childNode) {
                if (!($childNode instanceof \DOMText)) {
                    continue 2;
                }
            }

            self::drawNodes($nodes->createNodeList(array($node)), $spec);
        }

        return $this;
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

    /**
     * @param array $spec
     * @param VarTranslator $varTranslator
     * @param ArrayAccess $translation
     * @return AbstractDrawElement
     */
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
