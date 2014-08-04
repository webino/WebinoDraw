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

use WebinoDraw\Exception\RuntimeException;

/**
 *
 */
class Html implements InLoopPluginInterface
{
    /**
     * @param PluginArgument $arg
     * @throws Exception\RuntimeException
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('html', $spec) || null === $spec['html']) {
            return;
        }

        $translatedHtml  = $arg->getHelper()->translateValue($spec['html'], $arg->getVarTranslation(), $spec);
        $node            = $arg->getNode();
        $node->nodeValue = '';

        if (empty($translatedHtml)) {
            return;
        }

        $frag = $node->ownerDocument->createDocumentFragment();
        $frag->appendXml($translatedHtml);
        if (!$frag->hasChildNodes()) {
            throw new RuntimeException('Invalid XHTML ' . $translatedHtml);
        }
        $node->appendChild($frag);
    }
}
