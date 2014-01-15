<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Dom\NodeList;

/**
 * Interface for draw helpers
 */
interface DrawHelperInterface
{
    /**
     * Provides manipulation over DOM elements
     *
     * @param NodeList $nodes Matched DOM nodes.
     * @param array $spec Draw helper options.
     */
    public function drawNodes(NodeList $nodes, array $spec);

    /**
     * @return array
     */
    public function getVars();

    /**
     * @param  array $vars
     * @return DrawHelperInterface
     */
    public function setVars(array $vars);
}
