<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw;

use WebinoDraw\Exception\InvalidHelperException;
use WebinoDraw\Draw\Helper\HelperInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;

/**
 *
 */
class HelperPluginManager extends AbstractPluginManager
{
    /**
     * Default set of helpers factories
     *
     * @var array
     */
    protected $factories = [
        'webinodrawabsolutize' => 'WebinoDraw\Draw\Helper\Factory\AbsolutizeFactory',
        'webinodrawform'       => 'WebinoDraw\Draw\Helper\Factory\FormFactory',
    ];

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = [
        'webinodrawelement' => 'WebinoDraw\Draw\Helper\Element',
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
            ->addInitializer(array($this, 'injectManipulator'))
            ->addInitializer(array($this, 'injectVarTranslator'))
            ->addInitializer(array($this, 'injectCache'));
    }

    /**
     * Inject a helper instance with the WebinoDraw VarTranslator
     *
     * @param HelperInterface $helper
     */
    public function injectManipulator(HelperInterface $helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has('WebinoDraw\Manipulator\Manipulator')) {
            $helper->setManipulator($locator->get('WebinoDraw\Manipulator\Manipulator'));
            return;
        }
    }

    /**
     * Inject a helper instance with the registered translator
     *
     * @param HelperInterface $helper
     */
    public function injectVarTranslator(HelperInterface $helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has('WebinoDraw\VarTranslator\VarTranslator')) {
            $helper->setVarTranslator($locator->get('WebinoDraw\VarTranslator\VarTranslator'));
            return;
        }
    }

    /**
     * Inject a helper instance with the cache
     *
     * @param HelperInterface $helper
     */
    public function injectCache(HelperInterface $helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has('WebinoDrawCache')) {
            $helper->setCache($locator->get('WebinoDrawCache'));
            return;
        }
    }

    /**
     * Validate the plugin
     *
     * Checks that the helper loaded is an instance of Helper\HelperInterface.
     *
     * @param  mixed $plugin
     * @throws Exception\InvalidHelperException if invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof HelperInterface) {
            // we're okay
            return;
        }

        throw new InvalidHelperException(
            sprintf(
                'Plugin of type %s is invalid; must implement %s\Helper\HelperInterface',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            )
        );
    }
}
