<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory;

use WebinoDraw\Dom\Locator;
use WebinoDraw\Instructions\InstructionsRenderer;

/**
 * Class InstructionsRendererFactory
 */
class InstructionsRendererFactory extends AbstractInstructionsRendererFactory
{
    /**
     * Instructions renderer class
     */
    const ENGINE_CLASS = InstructionsRenderer::class;
}
