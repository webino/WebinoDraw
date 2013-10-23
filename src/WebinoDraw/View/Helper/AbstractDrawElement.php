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
use WebinoDraw\Exception;
use WebinoDraw\Stdlib\ArrayFetchInterface;

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
        $this->translateSpec($spec, $translation);

        empty($spec['render']) or
            $this->render($translation, $spec['render']);

        !array_key_exists('remove', $spec) or
            $nodes->remove($spec['remove']);

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

        !array_key_exists('onVar', $spec) or
            $this->onVar($nodes, $spec['onVar'], $translation);

        !array_key_exists('onEmpty', $spec) or
            $this->onEmpty($nodes, $spec['onEmpty']);

        return true;
    }

    /**
     * Loop target nodes by data.
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayFetchInterface $translation
     * @return AbstractDrawElement
     */
    protected function loop(NodeList $nodes, array $spec, ArrayFetchInterface $translation)
    {
        if (empty($spec['loop']['base'])) {
            throw new Exception\MissingPropertyException(
                sprintf('Loop base expected in: %s', print_r($spec, 1))
            );
        }

        !empty($spec['loop']['offset']) or
            $spec['loop']['offset'] = 0;

        !empty($spec['loop']['length']) or
            $spec['loop']['length'] = null;

        $items = array_slice(
            (array) $translation->fetch($spec['loop']['base']),
            $spec['loop']['offset'],
            $spec['loop']['length'],
            true
        );

        if (empty($items)) {
            // nothing to loop
            if (array_key_exists('onEmpty', $spec['loop'])) {

                $onEmptySpec = $spec['loop']['onEmpty'];
                $this->manipulateNodes($nodes, $onEmptySpec, $translation);

                empty($onEmptySpec['instructions']) or
                    $this->subInstructions($nodes, $onEmptySpec['instructions'], $translation);
            }

            return $this;
        }

        $varTranslator = $this->getVarTranslator();

        foreach ($nodes as $node) {

            if ($node->nextSibling) {
                $insertBefore = $node->nextSibling;
            } else {
                $insertBefore = null;
            }

            $nodeClone  = clone $node;
            $parentNode = $node->parentNode;

            $node->parentNode->removeChild($node);

            if (empty($spec['loop']['index'])) {
                $index = 0;
            } else {
                $index = $spec['loop']['index'];
            }

            foreach ($items as $key => $itemSubject) {
                $index++;

                $item = $varTranslator->subjectToArrayObject($itemSubject);

                $item[self::EXTRA_VAR_PREFIX . 'key']   = (string) $key;
                $item[self::EXTRA_VAR_PREFIX . 'index'] = (string) $index;

                // call loop item callback
                // todo callback array
                empty($spec['loop']['callback']) or
                    call_user_func_array($spec['loop']['callback'], array($item, $this));

                // create local translation
                $localTranslation = clone $translation;

                $varTranslator->translationMerge(
                    $localTranslation,
                    $item->getArrayCopy()
                );

                // add node
                $newNode = clone $nodeClone;

                if ($insertBefore) {
                    $parentNode->insertBefore($newNode, $insertBefore);
                } else {
                    $parentNode->appendChild($newNode);
                }

                // manipulate item nodes with local spec and translation
                $newNodeList = $nodes->createNodeList(array($newNode));
                $localSpec   = $spec;
                $terminate   = !$this->manipulateNodes($newNodeList, $localSpec, $localTranslation);

                if ($terminate || empty($spec['loop']['instructions'])) {
                    continue;
                }

                // render sub-instructions
                $this
                    ->cloneInstructionsPrototype($spec['loop']['instructions'])
                    ->render(
                       $newNode,
                       $this->view,
                       $localTranslation->getArrayCopy()
                   );
            }
        }

        return $this;
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
        $val = $this->getVarTranslator()->removeVars($spec['var']);
        if ($val !== $spec['equalTo']) {
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
        $val = $this->getVarTranslator()->removeVars($spec['var']);
        if ($val === $spec['notEqualTo']) {
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
        $helper = $this; // todo PHP 5.4

        return function (
            Element $node,
            $value,
            $nodes
        ) use (
            $helper,
            $subject,
            $spec,
            $translation
        ) {
            return $helper->translateHtmlPreSet($subject, $node, $value, $nodes, $spec, clone $translation);
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

        $translation->merge(
            $nodeTranslation->getArrayCopy()
        );

        $this->applyVarTranslator($translation, $spec);

        $varTranslator->translate(
            $spec,
            $varTranslator->makeVarKeys($translation)
        );

        $this->applyVarTranslator($translation, $spec);

        $translatedValue = $varTranslator->translateString(
            $value,
            $varTranslator->makeVarKeys($translation)
        );

        return $varTranslator->removeVars($translatedValue);
    }

    /**
     * @param DOMNode $node
     * @param string $value
     * @param array $spec
     * @param ArrayAccess $translation
     * @return type
     */
    public function translateHtmlPreSet($subject, DOMNode $node, $value, NodeList $nodes,
                                        array &$spec, ArrayAccess $translation)
    {
        $varTranslator = $this->getVarTranslator();

        $this->applyVarTranslator($translation, $spec);

        $translatedValue = $varTranslator->translateString(
            $value,
            $varTranslator->makeVarKeys($translation)
        );

        // node translation
        $nodeTranslation = $this->nodeTranslation($node);

        $innerHtmlKey = self::EXTRA_VAR_PREFIX . 'innerHtml';
        $outerHtmlKey = self::EXTRA_VAR_PREFIX . 'outerHtml';

        // include node innerHTML to the translation
        (false === strpos($subject, $innerHtmlKey)) or
            $nodeTranslation[$innerHtmlKey] = $node->getInnerHtml();

        // include node outerHTML to the translation
        (false === strpos($subject, $outerHtmlKey)) or
            $nodeTranslation[$outerHtmlKey] = $node->getOuterHtml();

        $nodeTranslatedValue = $varTranslator->translateString(
            $translatedValue,
            $varTranslator->makeVarKeys($nodeTranslation)
        );

        if (empty($nodeTranslatedValue)
            && array_key_exists('onEmpty', $spec)
        ) {
            $this->manipulateNodes($nodes, $spec['onEmpty'], $translation);
            return '';
        }

        return $nodeTranslatedValue;
    }
}
