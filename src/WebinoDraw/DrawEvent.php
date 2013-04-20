<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw;

use ArrayObject;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\View\Helper\DrawHelperInterface;
use Zend\EventManager\Event;

/**
 *
 */
class DrawEvent extends Event
{
    /**
     * @var DrawHelperInterface
     */
    protected $helper;

    /**
     * @var NodeList
     */
    protected $nodes;

    /**
     * @var ArrayObject
     */
    protected $spec;

    /**
     * @return DrawHelperInterface
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * @param DrawHelperInterface $helper
     * @return DrawEvent
     */
    public function setHelper(DrawHelperInterface $helper)
    {
        $this->helper = $helper;
        return $this;
    }

    /**
     * @return NodeList
     */
    public function getNodes()
    {
        if (null == $this->nodes) {
            $this->setNodes(new NodeList);
        }

        return $this->nodes;
    }

    /**
     * @param NodeList $nodes
     * @return DrawEvent
     */
    public function setNodes(NodeList $nodes)
    {
        $this->setParam('nodes', $nodes);
        $this->nodes = $nodes;
        return $this;
    }

    /**
     * @return ArrayObject
     */
    public function getSpec()
    {
        if (null === $this->spec) {
            $this->setSpec(new ArrayObject);
        }

        return $this->spec;
    }

    /**
     * @param array|ArrayObject $spec
     * @return DrawEvent
     */
    public function setSpec($spec)
    {
        if (is_array($spec)) {

            $this->spec = $this->getSpec();
            $this->setParam('spec', $this->spec);

            $this->spec->exchangeArray(
                array_replace_recursive(
                    $this->spec->getArrayCopy(),
                    $spec
                )
            );
            return $this;
        }

        if ($spec instanceof ArrayObject) {
            $this->setParam('spec', $spec);
            $this->spec = $spec;
            return $this;
        }

        throw new \UnexpectedValueException(
            'Expected array|ArrayObject'
        );
    }

    /**
     * @return DrawEvent
     */
    public function clearSpec()
    {
        $this->spec = null;
        return $this;
    }
}
