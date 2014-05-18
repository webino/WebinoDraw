<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Locator;

class Remove implements InLoopPluginInterface
{

    protected $locator;

    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['remove'])) {
            return;
        }

        $node      = $arg->getNode();
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
