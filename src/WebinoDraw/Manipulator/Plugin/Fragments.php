<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Document;
use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Exception;

/**
 * Class Fragments
 */
class Fragments implements InLoopPluginInterface
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
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['fragments'])) {
            return;
        }

        $node = $arg->getNode();
        if (!($node instanceof Element)) {
            throw new Exception\LogicException('Expected node of type Dom\Element');
        }
        if (!($node->ownerDocument instanceof Document)) {
            throw new Exception\LogicException('Expects node ownerDocument of type Dom\Document');
        }

        $nodeXpath   = $node->ownerDocument->getXpath();
        $translation = $arg->getTranslation();

        foreach ($spec['fragments'] as $name => $fragmentLocator) {

            /** @var \DOMNodeList $subNodes */
            $subNodes = $nodeXpath->query($this->locator->set($fragmentLocator)->xpathMatchAny(), $node);
            if (0 === $subNodes->length) {
                // fragment not found
                // TODO profiler warning
                continue;
            }

            $subNode = $subNodes->item(0);
            if (!($subNode instanceof Element)) {
                throw new Exception\LogicException('Expected node of type Dom\Element');
            }

            $translation[$name . 'OuterHtml'] = $subNode->getOuterHtml();
            $translation[$name . 'InnerHtml'] = $subNode->getInnerHtml();
        }
    }
}
