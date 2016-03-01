<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Instructions;

use DOMNodeList;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Exception\LogicException;
use WebinoDraw\Service\DrawProfiler;

/**
 * Class ProfilingInstructionsRenderer
 */
class ProfilingInstructionsRenderer extends InstructionsRenderer
{
    /**
     * @var DrawProfiler
     */
    protected $profiler;

    /**
     * @return DrawProfiler
     */
    protected function getProfiler()
    {
        if (null === $this->profiler) {
            throw new LogicException('Expected profiler');
        }
        return $this->profiler;
    }

    /**
     * @param object|DrawProfiler $profiler
     * @return self
     */
    public function setProfiler(DrawProfiler $profiler)
    {
        $this->profiler = $profiler;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function createNodeSpec(array $specs)
    {
        $spec = parent::createNodeSpec($specs);
        $spec['_key'] = key($specs);
        return $spec;
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveIsNodeDisabled($node, array $spec)
    {
        $isDisabled = parent::resolveIsNodeDisabled($node, $spec);
        $this->getProfiler()->beginNodeRender($spec, $isDisabled);
        return $isDisabled;
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveIsEmptyNodes(DOMNodeList $nodes = null)
    {
        // TODO profiler
        return parent::resolveIsEmptyNodes($nodes);
    }

    /**
     * {@inheritdoc}
     */
    protected function drawNodes(DOMNodeList $nodes, $helper, array $spec, array $vars)
    {
        $profiler = $this->getProfiler();
        $profiler->beginNodesDraw($nodes, $helper, $spec, $vars);
        parent::drawNodes($nodes, $helper, $spec, $vars);
        $profiler->finishNodesDraw($nodes, $helper, $spec, $vars);
    }
}
