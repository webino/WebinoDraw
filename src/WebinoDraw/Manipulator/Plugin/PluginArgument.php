<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\NodeList;
use WebinoDraw\Helper\DrawHelperInterface;
use WebinoDraw\Stdlib\Translation;
use Zend\Stdlib\AbstractOptions;

/**
 *
 */
class PluginArgument extends AbstractOptions
{
    protected $helper;
    protected $nodes;
    protected $spec = [];
    protected $translation;
    protected $varTranslation;
    protected $stopManipulation = false;

    public function getHelper()
    {
        return $this->helper;
    }

    public function setHelper(DrawHelperInterface $helper)
    {
        $this->helper = $helper;
        return $this;
    }

    public function getNodes()
    {
        return $this->nodes;
    }

    public function setNodes(NodeList $nodes)
    {
        $this->nodes = $nodes;
        return $this;
    }

    public function getSpec()
    {
        return $this->spec;
    }

    public function setSpec(array $spec)
    {
        $this->spec = $spec;
        return $this;
    }

    public function getTranslation()
    {
        return $this->translation;
    }

    public function setTranslation(Translation $translation)
    {
        $this->translation = $translation;
        return $this;
    }

    public function getVarTranslation()
    {
        return $this->varTranslation;
    }

    public function setVarTranslation(Translation $varTranslation)
    {
        $this->varTranslation = $varTranslation;
        return $this;
    }

    public function isManipulationStopped()
    {
        return $this->stopManipulation;
    }

    public function stopManipulation($flag = true)
    {
        $this->stopManipulation = (bool) $flag;
        return $this;
    }
}
