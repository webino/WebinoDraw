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

use Zend\View\Helper\EscapeHtml;

/**
 *
 */
class Value extends AbstractPlugin implements InLoopPluginInterface
{
    /**
     * @var EscapeHtml
     */
    protected $escapeHtml;

    /**
     * @param EscapeHtml $escapeHtml
     */
    public function __construct(EscapeHtml $escapeHtml)
    {
        $this->escapeHtml = $escapeHtml;
    }

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        $node = $arg->getNode();

        if (!array_key_exists('value', $spec)
            || null === $spec['value']
        ) {
            return;
        }

        $varTranslation  = $arg->getVarTranslation();
        $translatedValue = $arg->getHelper()->translateValue($spec['value'], $varTranslation);
        $node->nodeValue = $this->escapeHtml->__invoke($varTranslation->removeVars($translatedValue));

        $this->updateNodeVarTranslation($node, $arg);
    }
}
