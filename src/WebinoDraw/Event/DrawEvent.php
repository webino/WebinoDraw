<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Event;

use ArrayObject;
use WebinoDraw\Exception\UnexpectedValueException;
use WebinoDraw\Exception\RuntimeException;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Draw\Helper\HelperInterface;
use Zend\EventManager\Event;
use Zend\Stdlib\ArrayUtils;

/**
 * Class DrawEvent
 */
class DrawEvent extends Event
{
    /**
     * @var HelperInterface
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
     * @return HelperInterface
     * @throws RuntimeException
     */
    public function getHelper()
    {
        if (null === $this->helper) {
            throw new RuntimeException('Expected helper');
        }
        return $this->helper;
    }

    /**
     * @param HelperInterface $helper
     * @return $this
     */
    public function setHelper(HelperInterface $helper)
    {
        $this->helper = $helper;
        return $this;
    }

    /**
     * @return NodeList
     * @throws RuntimeException
     */
    public function getNodes()
    {
        if (null == $this->nodes) {
            throw new RuntimeException('Expected nodes');
        }
        return $this->nodes;
    }

    /**
     * @param NodeList $nodes
     * @return $this
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
     * @return $this
     * @throws UnexpectedValueException
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

        throw new UnexpectedValueException('Expected array|ArrayObject');
    }

    /**
     * @return $this
     */
    public function clearSpec()
    {
        $this->spec = null;
        return $this;
    }

    /**
     * @param string|int $key
     * @param string|array|object $value
     * @return $this
     */
    public function setVar($key, $value)
    {
        $helper     = $this->getHelper();
        $vars       = $helper->getVars();
        $vars[$key] = $value;
        $helper->setVars($vars);
        return $this;
    }

    /**
     * @param array $vars
     * @return $this
     */
    public function setVars(array $vars)
    {
        $helper     = $this->getHelper();
        $helperVars = $helper->getVars();
        $helper->setVars(ArrayUtils::merge($helperVars, $vars));
        return $this;
    }
}
