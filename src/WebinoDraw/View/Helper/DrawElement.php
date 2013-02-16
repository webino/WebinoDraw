<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 * @package     WebinoDraw\View
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Stdlib\DrawInstructions;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Exception;

/**
 * Draw helper used for DOMElement modifications.
 *
 * @category    Webino
 * @package     WebinoDraw\View
 * @subpackage  Helper
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class DrawElement extends AbstractDrawElement
{
    /**
     * Return translated $spec by values in $translation.
     *
     * @param  array $spec
     * @param  array $translation
     * @return array
     */
    private function translateSpec(array $spec, array $translation)
    {
        $varTranslator = $this->getVarTranslator();

        empty($spec['var']['set']) or
            $varTranslator->translationMerge(
                $translation,
                $spec['var']['set']
            );

        empty($spec['var']['fetch']) or
            $varTranslator->translationFetch(
                $translation,
                $spec['var']['fetch']
            );

        empty($spec['render']) or
            $this->render($translation, $spec['render']);

        $this->applyVarTranslator($translation, $spec);

        $varTranslator->translate(
            $spec,
            $varTranslator->array2translation($translation)
        );

        return $spec;
    }

    /**
     * Manipulate nodes.
     *
     * @param  \WebinoDraw\Dom\NodeList $nodes
     * @param  array $spec
     * @param  array $translation
     * @return \WebinoDraw\View\Helper\DrawElement
     */
    private function doWork(NodeList $nodes, array $spec, array $translation)
    {
        $spec = $this->translateSpec($spec, $translation);
        unset($translation);

        !array_key_exists('remove', $spec) or
            $nodes->remove($spec['remove']);

        !array_key_exists('replace', $spec) or
            $this->replace($nodes, $spec);

        !array_key_exists('attribs', $spec) or
            $this->setAttribs($nodes, $spec);

        !array_key_exists('value', $spec) or
            $this->setValue($nodes, $spec);

        !array_key_exists('html', $spec) or
            $this->setHtml($nodes, $spec);

        !array_key_exists('onEmpty', $spec) or
            $this->onEmpty($nodes, $spec['onEmpty']);

        return $this;
    }

    /**
     * Draw nodes in list.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $translation = $this->getVars();

        if (empty($spec['loop'])) {
            $this->doWork($nodes, $spec, $translation);
        } else {
            $this->loop($nodes, $spec, $translation);
        }
    }

    /**
     * Set nodes text value.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function setValue(NodeList $nodes, array $spec)
    {
        $preSet = $this->valuePreSet($spec);
        $nodes->setValue($spec['value'], $preSet);
    }

    /**
     * Set nodes XHTML value.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function setHtml(NodeList $nodes, array $spec)
    {
        $preSet = $this->htmlPreSet($spec['html'], $spec);
        $nodes->setHtml($spec['html'], $preSet);
    }

    /**
     * Set nodes attributes.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function setAttribs(NodeList $nodes, array $spec)
    {
        $preSet = $this->attribsPreSet($spec);
        $nodes->setAttribs($spec['attribs'], $preSet);
    }

    /**
     * If node has no text value, draw it with onEmpty options.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function onEmpty(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            if (!empty($node->nodeValue)
                || is_numeric($node->nodeValue)
            ) {
                continue;
            }
            $this->drawNodes($nodes->createNodeList(array($node)), $spec);
        }
    }

    /**
     * Replace nodes with HTML.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function replace(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            if (is_array($spec['replace'])) {
                foreach ($spec['replace'] as $xpath => $html) {
                    $newNodes = $nodes->createNodeList(
                        $node->ownerDocument->xpath->query($xpath, $node)
                    );
                    $preSet   = $this->htmlPreSet($html, $spec);
                    $newNodes->replace($html, $preSet);
                    $subspec  = $spec;
                    unset($subspec['replace']);
                    $this->drawNodes($newNodes, $subspec);
                }
                continue;
            }

            $newNodes = $nodes->createNodeList(array($node));
            $preSet   = $this->htmlPreSet($spec['replace'], $spec);
            $newNodes->replace($spec['replace'], $preSet);
            $subspec  = $spec;
            unset($subspec['replace']);
            $this->drawNodes($newNodes, $subspec);
        }
    }

    /**
     * Render view script to {$var}.
     *
     * @param array $translation
     * @param array $options
     */
    public function render(array &$translation, array $options)
    {
        foreach ($options as $key => $value) {
            $translation[$key] = $this->view->render($value);
        }
    }

    /**
     * Loop target nodes by data.
     *
     * @param  \WebinoDraw\Dom\NodeList $nodes
     * @param  array $spec
     * @param  array $localTranslation
     * @return type
     */
    private function loop(NodeList $nodes, array $spec, array $translation)
    {
        $varTranslator = $this->getVarTranslator();

        if (empty($spec['loop']['base'])) {
            throw new Exception\MissingPropertyException(
                sprintf('Loop base expected in: %s', print_r($spec, 1))
            );
        }

        $items = DrawInstructions::toBase($translation, $spec['loop']['base']);

        if (empty($items)) {

            if (array_key_exists('onEmpty', $spec['loop'])) {
                $this->doWork($nodes, $spec['loop']['onEmpty'], $translation);
            }
            return;
        }

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

            foreach ($items as $key => $item) {
                $index++;

                $item['key']      = (string) $key;
                $item['index']    = (string) $index;
                $newNode          = clone $nodeClone;
                $newNodeList      = $nodes->createNodeList(array($newNode));
                $localTranslation = $translation;


                $varTranslator->translationMerge(
                    $localTranslation,
                    $item
                );

                $this->doWork($newNodeList, $spec, $localTranslation);

                empty($spec['loop']['instructions']) or
                    DrawInstructions::render(
                        $newNode,
                        $this->view,
                        $spec['loop']['instructions'],
                        $localTranslation
                    );

                if ($insertBefore) {
                    $parentNode->insertBefore($newNode, $insertBefore);
                } else {
                    $parentNode->appendChild($newNode);
                }
            }
        }
    }
}
