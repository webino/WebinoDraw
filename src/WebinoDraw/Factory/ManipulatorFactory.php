<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory;

use WebinoDraw\Cache\DrawCache;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Manipulator\Manipulator;
use WebinoDraw\Manipulator\Plugin;
use WebinoDraw\VarTranslator\VarTranslator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\EscapeHtml;

/**
 * Class ManipulatorFactory
 */
class ManipulatorFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return Manipulator
     */
    public function createService(ServiceLocatorInterface $services)
    {
        /** @var VarTranslator $varTranslator */
        $varTranslator = $services->get(VarTranslator::class);
        /** @var InstructionsRenderer $instructionsRenderer */
        $instructionsRenderer = $services->get(InstructionsRenderer::class);
        /** @var \WebinoDraw\Draw\LoopHelperPluginManager $drawLoopHelpers */
        $drawLoopHelpers = $services->get('WebinoDrawLoopHelperManager');
        /** @var DrawCache $drawCache */
        $drawCache = $services->get(DrawCache::class);
        /** @var \Zend\View\Renderer\PhpRenderer $viewRenderer */
        $viewRenderer = $services->get('ViewRenderer');
        /** @var Locator $domLocator */
        $domLocator = $services->get(Locator::class);

        return (new Manipulator($varTranslator))
            ->setPlugin(new Plugin\Loop($instructionsRenderer, $drawLoopHelpers, $drawCache), 500)
            ->setPlugin(new Plugin\Render($viewRenderer), 110)
            ->setPlugin(new Plugin\Fragments($domLocator), 100)
            ->setPlugin(new Plugin\NodeTranslation, 90)
            ->setPlugin(new Plugin\VarTranslation($varTranslator), 80)
            ->setPlugin(new Plugin\Remove($domLocator), 70)
            ->setPlugin(new Plugin\Replace, 60)
            ->setPlugin(new Plugin\Attribs, 50)
            ->setPlugin(new Plugin\Value(new EscapeHtml), 40)
            ->setPlugin(new Plugin\Html, 30)
            ->setPlugin(new Plugin\Cdata($instructionsRenderer), 20)
            ->setPlugin(new Plugin\OnVar($varTranslator, $instructionsRenderer), 10)
            ->setPlugin(new Plugin\OnEmpty($instructionsRenderer), -100)
            ->setPlugin(new Plugin\SubInstructions($instructionsRenderer), -500);
    }
}
