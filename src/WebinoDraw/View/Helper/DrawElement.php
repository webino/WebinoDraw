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
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
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

        $this->drawNodes($nodes, $event->getSpec()->getArrayCopy());

        $this->cacheSave($nodes, $spec);
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawElement
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $translation = $this->cloneTranslationPrototype($this->getVars());

        if (!empty($spec['loop'])) {
            $this->loop($nodes, $spec, $translation);
            return $this;
        }

        if (!$this->manipulateNodes($nodes, $spec, $translation)) {
            return $this;
        }

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

        return $this;
    }

    /**
     * Manipulate nodes
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return bool
     */
    protected function manipulateNodes(NodeList $nodes, array $spec, ArrayAccess $translation)
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

        !array_key_exists('onEmpty', $translatedSpec) or
            $this->onEmpty($nodes, $translatedSpec['onEmpty']);

        return true;
    }

    /**
     * Loop target nodes by data.
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayFetchInterface $translation
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

                $item[self::EXTRA_VAR_PREFIX . 'key']   = (string) $key;
                $item[self::EXTRA_VAR_PREFIX . 'index'] = (string) $index;

                $newNode          = clone $nodeClone;
                $newNodeList      = $nodes->createNodeList(array($newNode));
                $localTranslation = clone $translation;


                $varTranslator->translationMerge(
                    $localTranslation,
                    $item
                );

                if (!$this->manipulateNodes($newNodeList, $spec, $localTranslation)) {
                    continue;
                }

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
     * @param ArrayAccess $translation
     * @return DrawElement
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
     * @return DrawElement
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
     * Set attributes for each node in the list
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return DrawElement
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

            self::drawNodes($nodes->createNodeList(array($node)), $spec);
        }

        return $this;
    }

    /**
     * Replace nodes with XHTML
     *
     * @param NodeList $nodes
     * @param array $spec
     * @param ArrayAccess $translation
     * @return DrawElement
     */
    protected function replace(NodeList $nodes, array $spec, ArrayAccess $translation)
    {
        if (empty($spec['replace'])) {
            throw new \UnexpectedValueException('Expected $spec[replace]');
        }

        if (!empty($spec['locator'])) {

            $locator = $nodes->getLocator();

            foreach ($nodes as $node) {

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
        $this->applyVarTranslator($translation, $spec);

        $varTranslator = $this->getVarTranslator();
        $varTranslator->translate(
            $spec,
            $varTranslator->makeVarKeys($translation)
        );

        return $spec;
    }
}
