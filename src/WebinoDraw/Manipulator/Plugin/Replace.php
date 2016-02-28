<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use DOMElement;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\Dom\Text;
use WebinoDraw\Draw\Helper\AbstractHelper;
use WebinoDraw\Exception;

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
        if (!($node instanceof Element) && !($node instanceof Text)) {
            throw new Exception\LogicException(
                sprintf('Expected node of type %s or %s ', Element::class, Text::class)
            );
        }

        if (empty($node->parentNode)) {
            // node already removed
            return;
        }

        $node->nodeValue = '';
        $varTranslation  = $arg->getVarTranslation();

        $helper = $arg->getHelper();
        if (!($helper instanceof AbstractHelper)) {
            throw new Exception\LogicException('Expected draw helper of type ' . AbstractHelper::class);
        }

        $translatedHtml = $helper->translateValue($spec['replace'], $varTranslation, $spec);
        if (empty($translatedHtml)) {
            return;
        }

        $newNode = $node->replaceWith($translatedHtml);
        $this->nodesToRemove[] = $node;
        if ($newNode instanceof NodeInterface) {
            $arg->setNode($newNode);
            $this->updateNodeVarTranslation($newNode, $arg);
        }
    }

    /**
     * @param PluginArgument $arg
     */
    public function postLoop(PluginArgument $arg)
    {
        foreach ($this->nodesToRemove as $node) {
            if ($node instanceof DOMElement && !empty($node->parentNode)) {
                $node->parentNode->removeChild($node);
            }
        }
    }
}
