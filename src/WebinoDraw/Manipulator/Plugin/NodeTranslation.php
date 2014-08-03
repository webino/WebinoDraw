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

use WebinoDraw\Dom\Element;

/**
 *
 */
class NodeTranslation implements InLoopPluginInterface
{
    /**
     * @var array
     */
    protected $lastNodeTranslation = [];

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $node = $arg->getNode();
        if (!$node instanceof Element) {
            return;
        }

        $translation = $arg->getTranslation();
        // unset the last node translation then merge current one
        $nodeTranslation = $translation->createNodeTranslation($node, $arg->getSpec());
        $translation->unsetKeys(array_keys($this->lastNodeTranslation));
        $this->lastNodeTranslation = $nodeTranslation->getArrayCopy();
        $translation->merge($this->lastNodeTranslation);
    }
}
