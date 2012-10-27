<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Dom\NodeList;

/**
 * Draw helper used for DOMElement modifications.
 *
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  Helper
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

        empty($spec['var']['default']) or
            $varTranslator->translationDefaults(
                $translation,
                $spec['var']['default']
            );

        empty($spec['render']) or
            $this->render($translation, $spec['render']);

        empty($spec['var']['helper']) or
            $varTranslator->applyHelper(
                $translation,
                $spec['var']['helper'],
                $this->view->getHelperPluginManager()
            );

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
        $preSet = $this->getValuePreSet($spec);
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
        $preSet = $this->getHtmlPreSet($spec['html'], $spec);
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
        $preSet = $this->getAttribsPreSet($spec);
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
                    $preSet   = $this->getHtmlPreSet($html, $spec);
                    $newNodes->replace($html, $preSet);
                    $subspec  = $spec;
                    unset($subspec['replace']);
                    $this->drawNodes($newNodes, $subspec);
                }
                continue;
            } else {
                $newNodes = $nodes->createNodeList(array($node));
            }
            $newNodes = $nodes->createNodeList(array($node));
            $preSet   = $this->getHtmlPreSet($spec['replace'], $spec);
            $newNodes->replace($spec['replace'], $preSet);
            $subspec  = $spec;
            unset($subspec['replace']);
            $this->drawNodes($newNodes, $subspec);
        }
    }

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
     * @param  array $translation
     * @return type
     */
    private function loop(NodeList $nodes, array $spec, array $translation)
    {
        $varTranslator = $this->getVarTranslator();

        // todo
        if (empty($translation['items'])) {

            // onEmpty
            !array_key_exists('onEmpty', $spec['loop']) or
                $this->doWork($nodes, $spec['loop']['onEmpty'], $translation);

            return;
        }
        $items = $translation['items'];

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

                $item['key']   = (string) $key;
                $item['index'] = (string) $index;
                $newNode       = clone $nodeClone;
                $newNodeList   = $nodes->createNodeList(array($newNode));

                $varTranslator->translationMerge(
                    $translation,
                    $item
                );

                $this->doWork($newNodeList, $spec, $translation);

                if ($insertBefore) {
                    $parentNode->insertBefore($newNode, $insertBefore);
                } else {
                    $parentNode->appendChild($newNode);
                }
            }
        }
    }
}
