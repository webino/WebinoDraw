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

            $this->applyVarTranslator($translation, $spec);

            $varTranslation = $varTranslator->makeVarKeys($translation);

            // start manipulation
            // todo redesign

            if (array_key_exists('remove', $spec)) {

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

            if (array_key_exists('replace', $spec)) {

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
                $varTranslation->merge($varTranslator->makeVarKeys($this->nodeHtmlTranslation($node, $spec))->getArrayCopy());
            }

            if (array_key_exists('attribs', $spec)) {

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
                $varTranslation->merge($varTranslator->makeVarKeys($this->nodeHtmlTranslation($node, $spec))->getArrayCopy());
            }

            if (array_key_exists('value', $spec)) {

                $translatedValue = $this->translateValue(
                    $spec['value'],
                    $varTranslation,
                    $spec
                );

                $node->nodeValue = $view->escapeHtml($varTranslator->removeVars($translatedValue));

                // update node html var translation
                $varTranslation->merge($varTranslator->makeVarKeys($this->nodeHtmlTranslation($node, $spec))->getArrayCopy());
            }

            if (array_key_exists('html', $spec)) {

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

            if (array_key_exists('cdata', $spec)) {

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

            if (array_key_exists('onVar', $spec)) {

                foreach ($spec['onVar'] as $onVarSpecKey => $onVarSpec) {
                    if (!array_key_exists('var', $onVarSpec)) {
                        throw new Exception\InvalidInstructionException(
                            'Expected `var` option in ' . print_r($onVarSpec, true)
                        );
                    }

                    $val = $varTranslator->removeVars(
                        $varTranslator->translateString(
                            $onVarSpec['var'],
                            $varTranslation
                        )
                    );

                    if (array_key_exists('equalTo', $onVarSpec)) {

                        if ($val === $onVarSpec['equalTo']) {

                            $this->subInstructions(
                                $nodes,
                                $spec['onVar'][$onVarSpecKey]['instructions'],
                                $translation
                            );
                        }
                    }

                    if (array_key_exists('notEqualTo', $onVarSpec)) {

                        if ($val !== $onVarSpec['notEqualTo']) {

                            $this->subInstructions(
                                $nodes,
                                $spec['onVar'][$onVarSpecKey]['instructions'],
                                $translation
                            );
                        }
                    }
                }
            }

            if (array_key_exists('onEmpty', $spec)) {

                if ($node->isEmpty()) {
                    $onEmptySpec = $spec['onEmpty'];

                    if (!empty($onEmptySpec['locator'])) {
                        $this->subInstructions($nodes, array($onEmptySpec), $translation);

                    } else {
                        $this->manipulateNodes($nodes, $onEmptySpec, $translation);

                        empty($onEmptySpec['instructions']) or
                            $this->subInstructions($nodes, $onEmptySpec['instructions'], $translation);
                    }
                }
            }

            empty($spec['instructions']) or
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
                    $this->manipulateNodes($nodes, $onEmptySpec, $translation);

                    empty($onEmptySpec['instructions']) or
                        $this->subInstructions($nodes, $onEmptySpec['instructions'], $translation);
                }
            }

            return $this;
        }

        $varTranslator = $this->getVarTranslator();

        foreach ($nodes as $node) {

            $insertBefore = $node->nextSibling ? $node->nextSibling : null;
            $nodeClone    = clone $node;
            $parentNode   = $node->parentNode;

            $node->parentNode->removeChild($node);

            $index = !empty($spec['loop']['index']) ? $spec['loop']['index'] : 0;
            foreach ($items as $key => $itemSubject) {
                $index++;

                $item = $varTranslator->subjectToArrayObject($itemSubject);
                $item[self::EXTRA_VAR_PREFIX . 'key']   = (string) $key;
                $item[self::EXTRA_VAR_PREFIX . 'index'] = (string) $index;

                // call loop item callback
                if (!empty($spec['loop']['callback'])) {
                    foreach ((array) $spec['loop']['callback'] as $callback) {
                        call_user_func_array($callback, array($item, $this));
                    }
                }

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
                $this->manipulateNodes($newNodeList, $spec, $localTranslation);

                if (empty($spec['loop']['instructions'])) {
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

    protected function translateValue($value, ArrayAccess $varTranslation, array $spec)
    {
        return $this->getVarTranslator()->translateString(
            $value,
            $varTranslation
        );
    }
}
