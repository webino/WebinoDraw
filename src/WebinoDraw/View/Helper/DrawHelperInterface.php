<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Dom\NodeList;

/**
 * Interface for draw helpers.
 *
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  Helper
 */
interface DrawHelperInterface
{
    /**
     * Provide manipulation over DOM elements.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes Matched DOM nodes.
     * @param array $spec Draw helper options.
     */
    public function drawNodes(NodeList $nodes, array $spec);

    /**
     * Get variables used.
     *
     * @return array
     */
    public function getVars();

    /**
     * Set variables to used in the scope.
     *
     * @param  array $vars
     * @return WebinoDraw\Draw\Helper\DrawHelperInterface
     */
    public function setVars(array $vars);
}
