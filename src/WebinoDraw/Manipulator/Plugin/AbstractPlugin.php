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

use WebinoDraw\Dom\NodeInterface;

/**
 *
 */
abstract class AbstractPlugin
{
    /**
     * @param NodeInterface $node
     * @param PluginArgument $arg
     * @return self
     */
    protected function updateNodeVarTranslation(NodeInterface $node, PluginArgument $arg)
    {
        $arg->getVarTranslation()->merge(
            $arg->getTranslation()->createNodeVarTranslationArray($node, $arg->getSpec())
        );
        return $this;
    }
}
