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

                $item = new \ArrayObject($varTranslator->subjectToArray($itemSubject));

                $item[self::EXTRA_VAR_PREFIX . 'key']   = (string) $key;
                $item[self::EXTRA_VAR_PREFIX . 'index'] = (string) $index;

                empty($spec['loop']['callback']) or
                    call_user_func_array($spec['loop']['callback'], array($item, $this));

                $newNode          = clone $nodeClone;
                $newNodeList      = $nodes->createNodeList(array($newNode));
                $localTranslation = clone $translation;

                $varTranslator->translationMerge(
                    $localTranslation,
                    $item->getArrayCopy()
                );

                if ($insertBefore) {
                    $parentNode->insertBefore($newNode, $insertBefore);
                } else {
                    $parentNode->appendChild($newNode);
                }

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
            }
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
