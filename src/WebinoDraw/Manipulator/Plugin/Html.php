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

use WebinoDraw\Exception;
use WebinoDraw\Dom\Element;

/**
 * Class Html
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

        $node = $arg->getNode();
        if (!($node instanceof Element)) {
            throw new Exception\LogicException('Expected node of type ' . Element::class);
        }

        $node->nodeValue = '';
        $translatedHtml  = $arg->getHelper()->translateValue($spec['html'], $arg->getVarTranslation(), $spec);

        empty($translatedHtml)
            or $node->appendHtml($translatedHtml);
    }
}
