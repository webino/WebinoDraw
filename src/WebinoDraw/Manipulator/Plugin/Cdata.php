<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use DOMElement;
use WebinoDraw\Exception;
use WebinoDraw\Instructions\InstructionsRenderer;

/**
 *
 */
class Cdata implements InLoopPluginInterface
{
    /**
     * @var InstructionsRenderer
     */
    protected $instructionsRenderer;

    /**
     * @param InstructionsRenderer $instructionsRenderer
     */
    public function __construct(InstructionsRenderer $instructionsRenderer)
    {
        $this->instructionsRenderer = $instructionsRenderer;
    }

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (!array_key_exists('cdata', $spec) || null === $spec['cdata']) {
            return;
        }

        $node = $arg->getNode();
        if (!($node instanceof DOMElement)) {
            throw new Exception\LogicException('Expected node of type DOMElement');
        }

        $node->nodeValue = '';
        $translatedCdata = $arg->getHelper()->translateValue($spec['cdata'], $arg->getVarTranslation(), $spec);
        if (empty($translatedCdata)) {
            return;
        }

        $node->appendChild($node->ownerDocument->createCdataSection($translatedCdata));
    }
}
