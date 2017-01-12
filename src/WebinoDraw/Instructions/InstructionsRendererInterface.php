<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Instructions;

use WebinoDraw\Dom\NodeInterface;

/**
 *
 */
interface InstructionsRendererInterface
{
    /**
     * Render the DOMNode
     *
     * @param NodeInterface $node DOMNode
     * @param array|InstructionsInterface $instructions Draw instructions
     * @param array $vars Variables to render
     */
    public function render(NodeInterface $node, $instructions, array $vars);
}
