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

use Zend\View\Renderer\PhpRenderer;

/**
 *
 */
class Render implements PreLoopPluginInterface
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
    public function preLoop(PluginArgument $arg)
    {
        $spec = $arg->getSpec();
        if (empty($spec['render'])) {
            return;
        }

        $translation = $arg->getTranslation();
        foreach ($spec['render'] as $key => $value) {
            $translation[$key] = $this->renderer->render($value);
        }
    }
}
