<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use DOMElement;
use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\Draw\Helper\AbstractHelper;
use WebinoDraw\Exception;
use WebinoDraw\Dom\Document;

/**
 * Class Replace
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
        if (!($node instanceof NodeInterface)) {
            throw new Exception\LogicException('Expected node of type ' . NodeInterface::class);
        }

        if (empty($node->parentNode)) {
            // node already removed
            return;
        }

        /** @var DOMElement $node */
        $node->nodeValue = '';
        $varTranslation  = $arg->getVarTranslation();

        $helper = $arg->getHelper();
        if (!($helper instanceof AbstractHelper)) {
            throw new Exception\LogicException('Expected draw helper of type ' . AbstractHelper::class);
        }

        $translatedHtml = $helper->translateValue($spec['replace'], $varTranslation, $spec);
        if (!empty($translatedHtml)) {
            $arg->setNode($node->replaceWith($translatedHtml));
            $this->nodesToRemove[] = $node;
        }

        /** @var NodeInterface $node */
        $this->updateNodeVarTranslation($node, $arg);
    }

    /**
     * @param PluginArgument $arg
     */
    public function postLoop(PluginArgument $arg)
    {
        foreach ($this->nodesToRemove as $node) {
            if (!($node instanceof DOMElement)) {
                throw new Exception\LogicException('Expected node of type ' . DOMElement::class);
            }

            empty($node->parentNode)
                or $node->parentNode->removeChild($node);
        }
    }
}
