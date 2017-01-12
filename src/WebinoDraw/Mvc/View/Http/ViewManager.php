<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Mvc\View\Http;

use WebinoDraw\View\Renderer\NotPhpRenderer;
use Zend\Mvc\View\Http\ViewManager as BaseViewManager;

/**
 *
 */
class ViewManager extends BaseViewManager
{
    /**
     * {@inheritDoc}
     */
    public function getRenderer()
    {
        if ($this->renderer) {
            return $this->renderer;
        }

        $this->renderer = new NotPhpRenderer;
        $this->renderer->setHelperPluginManager($this->getHelperManager());
        $this->renderer->setResolver($this->getResolver());

        $model       = $this->getViewModel();
        $modelHelper = $this->renderer->plugin('view_model');
        $modelHelper->setRoot($model);

        $this->services->setService('ViewRenderer', $this->renderer);
        $this->services->setAlias('Zend\View\Renderer\PhpRenderer', 'ViewRenderer');
        $this->services->setAlias('Zend\View\Renderer\RendererInterface', 'ViewRenderer');

        return $this->renderer;
    }
}
