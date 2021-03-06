<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Draw\Helper\HelperInterface;
use WebinoDraw\VarTranslator\Translation;
use Zend\Stdlib\AbstractOptions;

/**
 *
 */
class PluginArgument extends AbstractOptions
{
    /**
     * @var HelperInterface
     */
    protected $helper;

    /**
     * @var NodeInterface
     */
    protected $node;

    /**
     * @var NodeList
     */
    protected $nodes;

    /**
     * @var array
     */
    protected $spec = [];

    /**
     * @var Translation
     */
    protected $translation;

    /**
     * @var Translation
     */
    protected $varTranslation;

    /**
     * @var bool
     */
    protected $stopManipulation = false;

    /**
     * @return HelperInterface
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * @param HelperInterface $helper
     * @return self
     */
    public function setHelper(HelperInterface $helper)
    {
        $this->helper = $helper;
        return $this;
    }

    /**
     * @return NodeInterface
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param NodeInterface $node
     * @return self
     */
    public function setNode(NodeInterface $node)
    {
        $this->node = $node;
        return $this;
    }

    /**
     * @return NodeList
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param NodeList $nodes
     * @return self
     */
    public function setNodes(NodeList $nodes)
    {
        $this->nodes = $nodes;
        return $this;
    }

    /**
     * @return array
     */
    public function getSpec()
    {
        return $this->spec;
    }

    /**
     * @param array $spec
     * @return self
     */
    public function setSpec(array $spec)
    {
        $this->spec = $spec;
        return $this;
    }

    /**
     * @return Translation
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * @param Translation $translation
     * @return self
     */
    public function setTranslation(Translation $translation)
    {
        $this->translation = $translation;
        return $this;
    }

    /**
     * @return Translation
     */
    public function getVarTranslation()
    {
        return $this->varTranslation;
    }

    /**
     * @param Translation $varTranslation
     * @return self
     */
    public function setVarTranslation(Translation $varTranslation)
    {
        $this->varTranslation = $varTranslation;
        return $this;
    }

    /**
     * @return bool
     */
    public function isManipulationStopped()
    {
        return $this->stopManipulation;
    }

    /**
     * @param bool $flag
     * @return self
     */
    public function stopManipulation($flag = true)
    {
        $this->stopManipulation = (bool) $flag;
        return $this;
    }
}
