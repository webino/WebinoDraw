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

use WebinoDraw\Instructions\InstructionsRenderer;

/**
 *
 */
class OnEmpty implements InLoopPluginInterface
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
        if (empty($spec['onEmpty'])) {
            return;
        }

        $node = $arg->getNode();
        if (!$node->isEmpty()) {
            return;
        }

        $onEmptySpec = $spec['onEmpty'];
        $nodes       = $arg->getNodes()->create([$node]);
        $translation = $arg->getTranslation();

        if (!empty($onEmptySpec['locator'])) {
            $this->instructionsRenderer->subInstructions($nodes, [$onEmptySpec], $translation);
            return;
        }

        $this->instructionsRenderer->expandInstructions($onEmptySpec, $translation);
        empty($onEmptySpec['instructions'])
            or $this->instructionsRenderer->subInstructions(
                $nodes,
                $onEmptySpec['instructions'],
                $translation
            );

        $arg->getHelper()->manipulateNodes($nodes, $onEmptySpec, $translation);
    }
}
