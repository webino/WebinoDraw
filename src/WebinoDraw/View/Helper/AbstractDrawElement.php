<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use ArrayAccess;
use DOMText;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\Locator;
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

        } else {
            $this->manipulateNodes($nodes, $spec, $translation);
        }

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
        $view          = $this->getView();
        $varTranslator = $this->getVarTranslator();
        $locator       = $nodes->getLocator();
        $nodesToRemove = array();

        foreach ($nodes as $node) {

            $translation->merge($this->nodeTranslation($node, $spec)->getArrayCopy());

            empty($spec['render']) or
                $this->render($translation, $spec['render']);

            empty($spec['fragments']) or
                $this->fragments($translation, $spec['fragments'], $node, $locator);

            $this->applyVarTranslator($translation, $spec);

            $varTranslation = $varTranslator->makeVarKeys($translation);

            // start manipulation
            // todo refactor

            if (!empty($spec['remove'])) {
                $nodeXpath = $node->ownerDocument->xpath;

                foreach ((array) $spec['remove'] as $removeLocator) {

                    $removeXpath = $locator->set($removeLocator)->xpathMatchAny();
                    $removeNodes = $nodeXpath->query($removeXpath, $node);

                    foreach ($removeNodes as $removeSubNode) {

                        empty($removeSubNode->parentNode) or
                            $removeSubNode->parentNode->removeChild($removeSubNode);
                    }
                }
            }

            if (array_key_exists('replace', $spec) && null !== $spec['replace']) {

                $translatedHtml = $this->translateValue(
                    $spec['replace'],
                    $varTranslation,
                    $spec
                );

                $node->nodeValue = '';

                if (!empty($translatedHtml)) {

                    $frag = $node->ownerDocument->createDocumentFragment();
                    $frag->appendXml($translatedHtml);

                    $newNode         = $node->parentNode->insertBefore($frag, $node);
                    $nodesToRemove[] = $node;
                    $node            = $newNode;
                }

                // update node html var translation
                $varTranslation->merge(
                    $varTranslator
                        ->makeVarKeys($this->nodeHtmlTranslation($node, $spec))
                        ->getArrayCopy()
                );
            }

            if (!empty($spec['attribs'])) {

                foreach ($spec['attribs'] as $attribName => $attribValue) {

                    $translatedAttribValue = $this->translateValue(
                        $attribValue,
                        $varTranslation,
                        $spec
                    );
                    $newAttribValue = $varTranslator->removeVars($translatedAttribValue);

                    if (empty($newAttribValue) && !is_numeric($newAttribValue)) {
                        $node->removeAttribute($attribName);

                    } else {
                        $node->setAttribute($attribName, trim($newAttribValue));
                    }
                }

                // update node html var translation
                $varTranslation->merge(
                    $varTranslator
                        ->makeVarKeys($this->nodeHtmlTranslation($node, $spec))
                        ->getArrayCopy()
                );
            }

            if (array_key_exists('value', $spec) && null !== $spec['value']) {

                $translatedValue = $this->translateValue(
                    $spec['value'],
                    $varTranslation,
                    $spec
                );

                $node->nodeValue = $view->escapeHtml($varTranslator->removeVars($translatedValue));

                // update node html var translation
                $varTranslation->merge(
                    $varTranslator
                        ->makeVarKeys($this->nodeHtmlTranslation($node, $spec))
                        ->getArrayCopy()
                );
            }

            if (array_key_exists('html', $spec) && null !== $spec['html']) {

                $translatedHtml = $this->translateValue(
                    $spec['html'],
                    $varTranslation,
                    $spec
                );

                $node->nodeValue = '';

                if (empty($translatedHtml)) {
                    if (array_key_exists('onEmpty', $spec)) {

                        $this->subInstructions($nodes, array($spec['onEmpty']), $translation);
                    }
                } else {

                    $frag = $node->ownerDocument->createDocumentFragment();
                    $frag->appendXml($translatedHtml);
                    $node->appendChild($frag);
                }
            }

            if (array_key_exists('cdata', $spec) && null !== $spec['cdata']) {

                $translatedCdata = $this->translateValue(
                    $spec['cdata'],
                    $varTranslation,
                    $spec
                );

                $node->nodeValue = '';

                if (empty($translatedCdata)) {
                    if (array_key_exists('onEmpty', $spec)) {

                        $this->subInstructions($nodes, array($spec['onEmpty']), $translation);
                    }
                } else {

                    $cdata = $node->ownerDocument->createCdataSection($translatedCdata);
                    $node->appendChild($cdata);
                }
            }

            if (!empty($spec['onVar'])) {
                $helper = $this; // todo PHP 5.4

                $varTranslator->applyOnVar(
                    $varTranslation,
                    $spec['onVar'],
                    function ($spec) use ($nodes, $translation, $helper) {

                        $helper
                            ->expandInstructionsFromSet($spec)
                            ->subInstructions(
                                $nodes,
                                $spec['instructions'],
                                $translation
                            );
                    }
                );
            }

            if (!empty($spec['onEmpty'])) {

                // todo better OOP
                if (($node instanceof Element && $node->isEmpty())
                    || ($node instanceof DOMText && '' === trim($node->nodeValue))
                ) {
                    $onEmptySpec = $spec['onEmpty'];

                    if (!empty($onEmptySpec['locator'])) {
                        $this->subInstructions($nodes, array($onEmptySpec), $translation);

                    } else {
                        $this
                            ->manipulateNodes($nodes, $onEmptySpec, $translation)
                            ->expandInstructionsFromSet($onEmptySpec);

                        empty($onEmptySpec['instructions']) or
                            $this->subInstructions($nodes, $onEmptySpec['instructions'], $translation);
                    }
                }
            }

            $this->expandInstructionsFromSet($spec);

            empty($spec['instructions']) || empty($node->ownerDocument) or
                $this->subInstructions($nodes->createNodeList(array($node)), $spec['instructions'], $translation);
        }

        // remove nodes
        foreach ($nodesToRemove as $nodeToRemove) {
            $nodeToRemove->parentNode->removeChild($nodeToRemove);
        }

        return $this;
    }

    /**
     * Loop target nodes by data
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

                if (!empty($onEmptySpec['locator'])) {
                    $this->subInstructions($nodes, array($onEmptySpec), $translation);

                } else {
                    $this
                        ->manipulateNodes($nodes, $onEmptySpec, $translation)
                        ->expandInstructionsFromSet($onEmptySpec);

                    empty($onEmptySpec['instructions']) or
                        $this->subInstructions($nodes, $onEmptySpec['instructions'], $translation);
                }
            }

            return $this;
        }

        empty($spec['loop']['shuffle']) or
            shuffle($items);

        $this
            ->expandInstructionsFromSet($spec)
            ->expandInstructionsFromSet($spec['loop']);

        $varTranslator = $this->getVarTranslator();

        foreach ($nodes as $node) {

            $beforeNode = $node->nextSibling ? $node->nextSibling : null;
            $nodeClone  = clone $node;
            $parentNode = $node->parentNode;
            $node->parentNode->removeChild($node);

            // create loop argument for better callback support
            $loopArgument = $varTranslator->subjectToArrayObject(
                array(
                    'spec'       => $spec,
                    'vars'       => $translation,
                    'parentNode' => $parentNode,
                    'beforeNode' => $beforeNode,
                    'target'     => $this,
                )
            );

            $loopArgument['index'] = !empty($spec['loop']['index']) ? $spec['loop']['index'] : 0;
            foreach ($items as $key => $item) {
                $loopArgument['index']++;

                $loopArgument['key']   = $key;
                $loopArgument['item']  = (array) $item;
                $loopArgument['node']  = clone $nodeClone;

                // call loop item callback
                if (!empty($spec['loop']['callback'])) {
                    foreach ((array) $spec['loop']['callback'] as $callback) {
                        $callback = (array) $callback;
                        call_user_func(current($callback), $loopArgument, (array) next($callback));

                        if (empty($loopArgument['node'])) {
                            // allows to skip node by callback
                            continue 2;
                        }
                    }
                }

                $loopArgument['item'][self::EXTRA_VAR_PREFIX . 'key']   = (string) $loopArgument['key'];
                $loopArgument['item'][self::EXTRA_VAR_PREFIX . 'index'] = (string) $loopArgument['index'];

                // create local translation
                $localTranslation = clone $translation;

                $varTranslator->translationMerge(
                    $localTranslation,
                    $loopArgument['item']
                );

                // add node
                if ($loopArgument['beforeNode']) {
                    $loopArgument['parentNode']->insertBefore($loopArgument['node'], $loopArgument['beforeNode']);
                } else {
                    $loopArgument['parentNode']->appendChild($loopArgument['node']);
                }

                // manipulate item nodes with local spec and translation
                $newNodeList = $nodes->createNodeList(array($loopArgument['node']));
                $this->manipulateNodes($newNodeList, $spec, $localTranslation);

                if (empty($spec['loop']['instructions'])) {
                    continue;
                }

                // render sub-instructions
                $this
                    ->cloneInstructionsPrototype($spec['loop']['instructions'])
                    ->render(
                        $loopArgument['node'],
                        $this->view,
                        $localTranslation->getArrayCopy()
                    );
            }

            empty($spec['instructions']) or
                $this->subInstructions($nodes->createNodeList(array($node)), $spec['instructions'], $translation);
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
     * Set target nodes HTML fragments into the translation
     *
     * @param ArrayAccess $translation
     * @param array $options
     * @param Element $node
     * @param Locator $locator
     * @return AbstractDrawElement
     */
    protected function fragments(ArrayAccess $translation, array $options, Element $node, Locator $locator)
    {
        $nodeXpath = $node->ownerDocument->xpath;

        foreach ($options as $name => $fragmentLocator) {

            $xpath = $locator->set($fragmentLocator)->xpathMatchAny();
            $node  = $nodeXpath->query($xpath, $node)->item(0);

            $translation[$name . 'OuterHtml'] = $node->getOuterHtml();
            $translation[$name . 'InnerHtml'] = $node->getInnerHtml();
        }

        return $this;
    }

    protected function translateValue($value, ArrayAccess $varTranslation, array $spec)
    {
        return $this->getVarTranslator()->translateString(
            $value,
            $varTranslation
        );
    }
}
