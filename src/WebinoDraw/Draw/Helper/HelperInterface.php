<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper;

use WebinoDraw\Dom\NodeList;

/**
 * Interface for draw helpers
 */
interface HelperInterface
{
    /**
     * Provides manipulation over DOM elements
     *
     * @param NodeList $nodes Matched DOM nodes
     */
    public function drawNodes(NodeList $nodes);

    /**
     * @return array
     */
    public function getSpec();

    /**
     * @param array $spec
     * @return self
     */
    public function setSpec(array $spec);

    /**
     * @return array
     */
    public function getVars();

    /**
     * @param array $vars
     * @return self
     */
    public function setVars(array $vars);
}
