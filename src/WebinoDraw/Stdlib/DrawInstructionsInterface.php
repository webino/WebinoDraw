<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Stdlib;

use DOMElement;
use Zend\View\Renderer\PhpRenderer;

/**
 *
 */
interface DrawInstructionsInterface
{
    /**
     * Merge draw instructions
     *
     * @param array $instructions Merge with
     * @param array $instructions Merge from
     * @return array Merged instructions
     */
    public function merge(array $instructions);

    /**
     * Render the DOMElement ownerDocument
     *
     * @param DOMElement $node DOMDocument element
     * @param PhpRenderer $renderer Provider of view helper
     * @param array $vars Variables to render
     */
    public function render(DOMElement $node, PhpRenderer $renderer, array $vars);
}
