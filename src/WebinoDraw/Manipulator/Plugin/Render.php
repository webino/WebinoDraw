<?php

namespace WebinoDraw\Manipulator\Plugin;

use ArrayAccess;
use Zend\View\Renderer\PhpRenderer;

class Render implements PreLoopPluginInterface
{
    /**
     * @var PhpRenderer
     */
    protected $renderer;

    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

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
