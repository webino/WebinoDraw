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
use WebinoDraw\Draw\Helper\Element;

/**
 * Custom (dependency injection) helper for test & example purposes
 */
class CustomDiHelper extends Element
{
    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $nodes->setValue('VALUE FROM CUSTOM DI HELPER');
    }
}
