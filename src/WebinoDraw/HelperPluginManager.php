<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

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
        'webinodrawabsolutize' => 'WebinoDraw\Helper\DrawAbsolutizeFactory',
        'webinodrawform'       => 'WebinoDraw\Helper\DrawFormFactory',
    ];

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = [
        'webinodrawelement' => 'WebinoDraw\Helper\DrawElement',
    ];

    /**
     * Constructor
     *
     * After invoking parent constructor, add an initializer to inject the
     * attached varTranslator, if any, to the currently requested helper.
     *
     * @param null|ConfigInterface $configuration
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);

        $this
            ->addInitializer(array($this, 'injectManipulator'))
            ->addInitializer(array($this, 'injectVarTranslator'));
    }

    /**
     * Inject a helper instance with the WebinoDraw VarTranslator
     *
     * @param  Helper\HelperInterface $helper
     */
    public function injectManipulator($helper)
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
     * @param  Helper\HelperInterface $helper
     * @return void
     */
    public function injectVarTranslator($helper)
    {
        $locator = $this->getServiceLocator();
        if (!$locator) {
            return;
        }

        if ($locator->has('WebinoDraw\Stdlib\VarTranslator')) {
            $helper->setVarTranslator($locator->get('WebinoDraw\Stdlib\VarTranslator'));
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
        if ($plugin instanceof Helper\DrawHelperInterface) {
            // we're okay
            return;
        }

        throw new Exception\InvalidHelperException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Helper\DrawHelperInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
