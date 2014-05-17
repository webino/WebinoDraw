<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\NodeInterface;

class Remove implements InLoopPluginInterface
{

    protected $locator;

    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['remove'])) {
            return;
        }

        $nodeXpath = $node->ownerDocument->xpath;
        foreach ((array) $spec['remove'] as $removeLocator) {

            $removeXpath = $this->locator->set($removeLocator)->xpathMatchAny();
            $removeNodes = $nodeXpath->query($removeXpath, $node);

            foreach ($removeNodes as $removeSubNode) {
                empty($removeSubNode->parentNode) or
                    $removeSubNode->parentNode->removeChild($removeSubNode);
            }
        }
    }
}
