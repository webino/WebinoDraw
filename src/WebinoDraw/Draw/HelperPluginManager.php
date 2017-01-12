<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw;

use WebinoDraw\Cache\DrawCache;
use WebinoDraw\Draw\Helper\Element;
use WebinoDraw\Exception;
use WebinoDraw\Draw\Helper;
use WebinoDraw\Factory\HelperFactory;
use WebinoDraw\Draw\Helper\HelperInterface;
use WebinoDraw\Manipulator\Manipulator;
use WebinoDraw\VarTranslator\VarTranslator;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;

/**
 * Class HelperPluginManager
 */
class HelperPluginManager extends AbstractPluginManager
{
    /**
     * Default set of helpers factories
     *
     * @var array
     */
    protected $factories = [
        Helper\Absolutize::SERVICE => HelperFactory\AbsolutizeFactory::class,
        Helper\Form::SERVICE       => HelperFactory\FormFactory::class,
        Helper\Translate::SERVICE  => HelperFactory\TranslateFactory::class,
        Helper\Pagination::SERVICE => HelperFactory\PaginationFactory::class,
    ];

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = [
        Element::SERVICE => Element::class,
    ];

    /**
     * Constructor
     *
     * After invoking parent constructor, add an initializer to inject the
     * attached helper, if any, to the currently requested helper.
     *
     * @param null|ConfigInterface $configuration
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);

        $this
            ->addInitializer([$this, 'injectEventManager'])
            ->addInitializer([$this, 'injectManipulator'])
            ->addInitializer([$this, 'injectVarTranslator'])
            ->addInitializer([$this, 'injectCache']);
    }

    /**
     * Inject a helper instance with the EventManager
     *
     * @param HelperInterface $helper
     */
    public function injectEventManager(HelperInterface $helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has('WebinoDraw')) {
            $helper->setEventManager($locator->get('WebinoDraw')->getEventManager());
            return;
        }
    }

    /**
     * Inject a helper instance with the WebinoDraw Manipulator
     *
     * @param HelperInterface $helper
     */
    public function injectManipulator(HelperInterface $helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has(Manipulator::class)) {
            $helper->setManipulator($locator->get(Manipulator::class));
            return;
        }
    }

    /**
     * Inject a helper instance with the WebinoDraw VarTranslator
     *
     * @param HelperInterface $helper
     */
    public function injectVarTranslator(HelperInterface $helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has(VarTranslator::class)) {
            $helper->setVarTranslator($locator->get(VarTranslator::class));
            return;
        }
    }

    /**
     * Inject a helper instance with the WebinoDraw DrawCache
     *
     * @param HelperInterface $helper
     */
    public function injectCache(HelperInterface $helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has(DrawCache::class)) {
            $helper->setCache($locator->get(DrawCache::class));
            return;
        }
    }

    /**
     * Validate the plugin
     *
     * Checks that the helper loaded is an instance of HelperInterface.
     *
     * @param mixed $plugin
     * @throws Exception\InvalidHelperException if invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof HelperInterface) {
            // we're okay
            return;
        }

        throw new Exception\InvalidHelperException(
            sprintf(
                'Plugin of type %s is invalid; must implement %s\Helper\HelperInterface',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            )
        );
    }
}
