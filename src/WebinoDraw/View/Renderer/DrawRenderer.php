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

use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Service\DrawService;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;

/**
 *
 */
class DrawRenderer implements RendererInterface
{
    /**
     * @var DrawService
     */
    protected $draw;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @param DrawService $draw
     * @param RendererInterface $renderer
     */
    public function __construct(DrawService $draw, RendererInterface $renderer)
    {
        $this->draw     = $draw;
        $this->renderer = $renderer;
    }

    /**
     * @return mixed
     */
    public function getEngine()
    {
        return $this->renderer->getEngine();
    }

    /**
     * @param ResolverInterface $resolver
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        return $this->renderer->setResolver($resolver);
    }

    /**
     * Render & draw the template
     *
     * @param string|ViewModel $nameOrModel The script/resource process, or a view model
     * @param null|array|\ArrayAccess $values Values to use during rendering
     * @return string The script output
     */
    public function render($nameOrModel, $values = null)
    {
        $isModel = $nameOrModel instanceof ViewModel;
        if (!is_string($nameOrModel) && !$isModel) {
            throw new InvalidArgumentException('Expected string|ViewModel');
        }

        $template     = $this->renderer->render($nameOrModel, $values);
        $instructions = clone $this->draw->getInstructions();
        $instructions->exchangeArray([]);

        if ($isModel) {
            // merge draw instructions
            foreach ((array) $nameOrModel->getOption('instructions') as $iOptions) {
                $instructions->merge($iOptions);
            }
        }

        $modelVars = $isModel ? (array) $nameOrModel->getVariables() : [];
        $variables = array_merge($modelVars, (array) $values);

        return $this->draw->draw(
            $template,
            $instructions,
            $variables,
            $isModel ? (bool) $nameOrModel->getOption('isXml') : false
        );
    }
}
