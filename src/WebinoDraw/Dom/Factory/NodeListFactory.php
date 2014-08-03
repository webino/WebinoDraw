<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom\Factory;

use DOMNodeList as DomNodeList;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Exception\InvalidArgumentException;

/**
 * Batch DOMElement manipulation
 */
class NodeListFactory
{
    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @param Locator $locator
     */
    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param array|DomNodeList $nodes DOMNodes in array or DOMNodelist
     * @return NodeList
     * @throws InvalidArgumentException
     */
    public function create($nodes)
    {
        if (!is_array($nodes) && !($nodes instanceof DomNodeList)) {
            throw new InvalidArgumentException('Expected nodes as array|DomNodeList');
        }

        return new NodeList($this->locator, $nodes);
    }
}
