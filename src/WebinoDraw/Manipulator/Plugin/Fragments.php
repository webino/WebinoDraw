<?php

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\NodeInterface;

class Fragments implements InLoopPluginInterface
{
    /**
     * @var Locator
     */
    protected $locator;

    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function inLoop(NodeInterface $node, PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['fragments'])) {
            return;
        }

        $translation = $arg->getTranslation();
        $nodeXpath   = $node->ownerDocument->xpath;

        foreach ($spec['fragments'] as $name => $fragmentLocator) {

            $xpath = $this->locator->set($fragmentLocator)->xpathMatchAny();
            $node  = $nodeXpath->query($xpath, $node)->item(0);

            $translation[$name . 'OuterHtml'] = $node->getOuterHtml();
            $translation[$name . 'InnerHtml'] = $node->getInnerHtml();
        }
    }
}
