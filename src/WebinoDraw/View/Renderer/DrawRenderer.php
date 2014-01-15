<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Renderer;

use WebinoDraw\WebinoDraw;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;

/**
 *
 */
class DrawRenderer implements RendererInterface
{
    /**
     * @var WebinoDraw
     */
    protected $webinoDraw;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @param RendererInterface $renderer
     */
    public function __construct(WebinoDraw $webinoDraw, RendererInterface $renderer)
    {
        $this->webinoDraw = $webinoDraw;
        $this->renderer   = $renderer;
    }

    /**
     * @return mixed
     */
    public function getEngine()
    {
        return $this->renderer->getEngine();
    }

    /**
     * @param  ResolverInterface $resolver
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        return $this->renderer->setResolver($resolver);
    }

    /**
     * Render & draw the template
     *
     * @param  string|ModelInterface   $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values      Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null)
    {
        $isModel = $nameOrModel instanceof ModelInterface;
        if (!is_string($nameOrModel) && !$isModel) {
            throw new \InvalidArgumentException('Expected string|ModelInterface');
        }

        $template     = $this->renderer->render($nameOrModel, $values);
        $instructions = clone $this->webinoDraw->getInstructions();
        $instructions->exchangeArray(array());

        if ($isModel) {
            // merge draw instructions
            foreach ((array) $nameOrModel->getOption('instructions') as $iOptions) {
                $instructions->merge($iOptions);
            }
        }

        $modelVars = $isModel ? $nameOrModel->getVariables()->getArrayCopy() : array();
        $variables = array_merge($modelVars, (array) $values);

        return $this->webinoDraw->draw(
            $template,
            $instructions,
            $variables,
            $isModel ? (bool) $nameOrModel->getOption('isXml') : false
        );
    }
}
