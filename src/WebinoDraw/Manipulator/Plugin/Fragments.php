<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Element;
use WebinoDraw\Dom\Locator;

/**
 *
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

        $translation = $arg->getTranslation();
        $nodeXpath   = $node->ownerDocument->getXpath();

        foreach ($spec['fragments'] as $name => $fragmentLocator) {

            $xpath = $this->locator->set($fragmentLocator)->xpathMatchAny();
            $node  = $nodeXpath->query($xpath, $node)->item(0);

            $translation[$name . 'OuterHtml'] = $node->getOuterHtml();
            $translation[$name . 'InnerHtml'] = $node->getInnerHtml();
        }
    }
}
