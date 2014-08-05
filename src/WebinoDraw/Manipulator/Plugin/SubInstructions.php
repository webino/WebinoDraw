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
use WebinoDraw\Dom\Document;
use WebinoDraw\Instructions\InstructionsRenderer;

/**
 *
 */
class SubInstructions implements InLoopPluginInterface
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
        $node = $arg->getNode();
        if (!($node instanceof DOMElement)) {
            throw new Exception\LogicException('Expected node of type DOMElement');
        }

        $spec = $arg->getSpec();
        $this->instructionsRenderer->expandInstructions($spec);
        if (!empty($spec['instructions']) && ($node->ownerDocument instanceof Document)) {
            $this->instructionsRenderer->subInstructions([$node], $spec['instructions'], $arg->getTranslation());
        }
    }
}
