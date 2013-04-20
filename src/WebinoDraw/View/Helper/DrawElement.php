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
use WebinoDraw\Stdlib\ArrayFetchInterface;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Exception;

/**
 * Draw helper used for DOMElement modifications.
 */
class DrawElement extends AbstractDrawElement
{
    /**
     * @var string
     */
    protected $eventIdentifier = __CLASS__;

    /**
     * Draw nodes in list
     *
     * @param NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        if ($this->cacheLoad($nodes, $spec)) {
            return;
        }

        $event = $this->getEvent();

        $event->clearSpec()
            ->setHelper($this)
            ->setSpec($spec)
            ->setNodes($nodes);

        !array_key_exists('trigger', $spec) or
            $this->trigger($spec['trigger']);

        $this->doWork($nodes, $event->getSpec()->getArrayCopy());

        $this->cacheSave($nodes, $spec);
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawElement
     */
    protected function doWork(NodeList $nodes, array $spec)
    {
        $translation = $this->cloneTranslationPrototype($this->getVars());

        if (empty($spec['loop'])) {

            $this->manipulateNodes($nodes, $spec, $translation);

            if (!empty($spec['instructions'])) {

                foreach ($nodes as $node) {

                    $this
                        ->cloneInstructionsPrototype($spec['instructions'])
                        ->render(
                           $node,
                           $this->view,
                           $translation->getArrayCopy()
                       );
                }
            }

        } else {
            $this->loop($nodes, $spec, $translation);
        }

        return $this;
    }

    /**
     * Manipulate nodes
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return DrawElement
     */
    protected function manipulateNodes(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        $_spec = $this->translateSpec($spec, $translation);

        !array_key_exists('remove', $_spec) or
            $nodes->remove($_spec['remove']);

        !array_key_exists('replace', $_spec) or
            $this->replace($nodes, $_spec);

        !array_key_exists('attribs', $_spec) or
            $this->setAttribs($nodes, $_spec);

        !array_key_exists('value', $_spec) or
            $this->setValue($nodes, $_spec);

        !array_key_exists('html', $_spec) or
            $this->setHtml($nodes, $_spec);

        !array_key_exists('onEmpty', $_spec) or
            $this->onEmpty($nodes, $_spec['onEmpty']);

        return $this;
    }

    /**
     * Loop target nodes by data.
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param array $translation
     * @return DrawElement
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
                $this->manipulateNodes($nodes, $spec['loop']['onEmpty'], $translation);
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

                $item = $varTranslator->subjectToArray($itemSubject);

                $item['key']      = (string) $key;
                $item['index']    = (string) $index;
                $newNode          = clone $nodeClone;
                $newNodeList      = $nodes->createNodeList(array($newNode));
                $localTranslation = clone $translation;


                $varTranslator->translationMerge(
                    $localTranslation,
                    $item
                );

                $this->manipulateNodes($newNodeList, $spec, $localTranslation);

                if (!empty($spec['loop']['instructions'])) {

                    $this
                        ->cloneInstructionsPrototype($spec['loop']['instructions'])
                        ->render(
                           $newNode,
                           $this->view,
                           $localTranslation->getArrayCopy()
                       );
                }

                if ($insertBefore) {
                    $parentNode->insertBefore($newNode, $insertBefore);
                } else {
                    $parentNode->appendChild($newNode);
                }
            }
        }

        return $this;
    }

    /**
     * Set text value for each node in the list
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawElement
     */
    protected function setValue(NodeList $nodes, array $spec)
    {
        $nodes->setValue(
            $spec['value'],
            $this->createValuePreSet($spec)
        );
        return $this;
    }

    /**
     * Set XHTML for each node in the list
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawElement
     */
    protected function setHtml(NodeList $nodes, array $spec)
    {
        if (empty($spec['html'])) {
            return $this;
        }

        $nodes->setHtml(
            $spec['html'],
            $this->createHtmlPreSet($spec['html'], $spec)
        );
        return $this;
    }

    /**
     * Set attributes for each node in the list
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawElement
     */
    protected function setAttribs(NodeList $nodes, array $spec)
    {
        $nodes->setAttribs(
            $spec['attribs'],
            $this->createAttribsPreSet($spec)
        );
        return $this;
    }

    /**
     * If node has no text value, draw it with onEmpty options
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawElement
     */
    protected function onEmpty(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {

            if (!empty($node->nodeValue)
                || is_numeric($node->nodeValue)
            ) {
                continue;
            }

            $this->doWork($nodes->createNodeList(array($node)), $spec);
        }

        return $this;
    }

    /**
     * Replace nodes with XHTML
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawElement
     */
    protected function replace(NodeList $nodes, array $spec)
    {
        if (empty($spec['replace'])) {
            throw new \UnexpectedValueException('Expected $spec[replace]');
        }

        empty($spec['locator']) or
            $xpath = $nodes->getLocator()->set($spec['locator'])->xpathMatchAny();

        foreach ($nodes as $node) {

            if (!empty($xpath)) {

                $nodeList = $node->ownerDocument->xpath->query($xpath);
            } else {

                $nodeList = array($node);
            }

            $newNodes = $nodes->createNodeList($nodeList);

            $newNodes->replace(
                $spec['replace'],
                $this->createHtmlPreSet($spec['replace'], $spec)
            );

            $subspec = $spec;
            unset($subspec['replace']);

            $this->doWork($newNodes, $subspec);
        }

        return $this;
    }

    /**
     * Render view script to {$var}
     *
     * @param ArrayAccess $translation
     * @param array $options
     * @return DrawElement
     */
    protected function render(ArrayAccess $translation, array $options)
    {
        foreach ($options as $key => $value) {
            $translation[$key] = $this->view->render($value);
        }

        return $this;
    }

    /**
     * Return translated $spec by values in $translation
     *
     * @param array $spec
     * @param ArrayAccess $translation
     * @return array
     */
    protected function translateSpec(array $spec, ArrayAccess $translation)
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
            $varTranslator->makeVarKeys($translation)
        );

        return $spec;
    }
}
