<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

use DOMNodeList as DomNodeList;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Batch DOMElement manipulation
 */
class NodeListFactory
{
    protected $services;

    public function __construct(ServiceLocatorInterface $services)
    {
        $this->services = $services;
    }

    /**
     * @param array|DomNodeList $nodes DOMNodes in array or DOMNodelist
     * @return NodeList
     */
    public function create($nodes)
    {
        if (!is_array($nodes) && !($nodes instanceof DomNodeList)) {
            throw new \InvalidArgumentException('Expected nodes as array|DomNodeList');
        }
        
        return new NodeList($this->services->get('WebinoDraw\Dom\Locator'), $nodes);
    }
}
