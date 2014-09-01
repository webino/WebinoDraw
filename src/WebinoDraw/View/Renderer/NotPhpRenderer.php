<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Renderer;

use Zend\View\Exception;
use Zend\View\Model\ModelInterface as Model;
use Zend\View\Renderer\PhpRenderer;

/**
 * Uses file_get_contents() instead of include
 *
 * <pre>
 * 'service_manager' => [
 *     'factories' => [
 *         'HttpViewManager' => 'WebinoDraw\Mvc\Service\HttpViewManagerFactory',
 *     ],
 * ],
 * </pre>
 */
class NotPhpRenderer extends PhpRenderer
{
    /**
     * {@inheritDoc}
     */
    private $__templates = array();

    /**
     * {@inheritDoc}
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof Model) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty',
                    __METHOD__
                ));
            }

            // Give view model awareness via ViewModel helper
            $this->plugin('view_model')->setCurrent($model);
        }

        // find the script file name using the parent private method
        $this->addTemplate($nameOrModel);
        unset($nameOrModel);

        $template = array_pop($this->__templates);
        $file     = $this->resolver($template);

        if (!$file) {
            throw new Exception\RuntimeException(sprintf(
                '%s: Unable to render template "%s"; resolver could not resolve to a file',
                __METHOD__,
                $template
            ));
        }

        if (false === is_file($file)) {
            throw new Exception\UnexpectedValueException(sprintf(
                '%s: Unable to render template "%s"; file not found',
                __METHOD__,
                $file
            ));
        }

        return $this->getFilterChain()->filter(file_get_contents($file));
    }

    /**
     * {@inheritDoc}
     */
    public function addTemplate($template)
    {
        $this->__templates[] = $template;
        return $this;
    }
}
