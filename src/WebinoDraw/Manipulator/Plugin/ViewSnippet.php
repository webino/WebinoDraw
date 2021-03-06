<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2019 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use Zend\View\Renderer\PhpRenderer;
use WebinoDraw\Dom\Element;

/**
 * Class ViewSnippet
 */
class ViewSnippet extends AbstractPlugin implements InLoopPluginInterface
{
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

        $spec['instructions']['view-snippet'] = [
            'locator' => 'view',
            'render'  => ['snippet' => '{$_snippet}'],
            'replace' => '{$snippet}',
        ];

        $arg->setSpec($spec);
    }
}
