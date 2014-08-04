<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use DOMElement;
use WebinoDraw\Exception;
use WebinoDraw\Dom\Document;

/**
 *
 */
class Replace extends AbstractPlugin implements
    InLoopPluginInterface,
    PostLoopPluginInterface
{
    /**
     * @var array
     */
    protected $nodesToRemove = [];

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('replace', $spec)
            || null === $spec['replace']
        ) {
            return;
        }

        $node = $arg->getNode();
        if (!($node instanceof DOMElement)) {
            throw new Exception\LogicException('Expected node of type DOMElement');
        }

        $node->nodeValue = '';
        $varTranslation  = $arg->getVarTranslation();
        $translatedHtml  = $arg->getHelper()->translateValue($spec['replace'], $varTranslation, $spec);

        if (!empty($translatedHtml)) {
            if (!($node->ownerDocument instanceof Document)) {
                throw new Exception\LogicException('Expects node ownerDocument of type Dom\Document');
            }

            $frag = $node->ownerDocument->createDocumentFragment();
            $frag->appendXml($translatedHtml);

            // insert new node remove old later
            $newNode = $node->parentNode->insertBefore($frag, $node);
            $arg->setNode($newNode);
            $this->nodesToRemove[] = $node;
        }

        $this->updateNodeVarTranslation($node, $arg);
    }

    /**
     * @param PluginArgument $arg
     */
    public function postLoop(PluginArgument $arg)
    {
        foreach ($this->nodesToRemove as $node) {
            if (!($node instanceof DOMElement)) {
                throw new Exception\LogicException('Expected node of type DOMElement');
            }

            empty($node->parentNode) or
                $node->parentNode->removeChild($node);
        }
    }
}
