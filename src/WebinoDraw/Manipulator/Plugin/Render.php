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

use Zend\View\Renderer\PhpRenderer;

use WebinoDraw\Dom\Element;

/**
 * Class Render
 */
class Render extends AbstractPlugin implements InLoopPluginInterface
{
    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * @param PhpRenderer $renderer
     */
    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param PluginArgument $arg
     */
    public function inLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['render'])) {
            return;
        }

        $node = $arg->getNode();
        if (!$node instanceof Element) {
            return;
        }

        $translation      = $arg->getTranslation();
        $translationClone = clone $translation;
        $nodeTranslation  = $this->createNodeTranslation($arg->getNode(), $arg->getSpec());
        $translationClone->merge($nodeTranslation->getArrayCopy());
        $varTranslation   = $translationClone->makeVarKeys();

        foreach ($spec['render'] as $key => $value) {
            $value and $translation[$key] = trim($this->renderer->render($varTranslation->translateString($value)));
        }
    }
}
