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

use WebinoDraw\Exception\InvalidHelperException;
use WebinoDraw\Draw\LoopHelper\HelperInterface;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class LoopHelperPluginManager
 *
 * @method HelperInterface get($name, $options = [], $usePeeringServiceManagers = true)
 */
class LoopHelperPluginManager extends AbstractPluginManager
{
    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = [
        'webinodrawloopitemproperty'   => 'WebinoDraw\Draw\LoopHelper\ItemProperty',
        'webinodrawloopelementwrapper' => 'WebinoDraw\Draw\LoopHelper\ElementWrapper',
    ];

    /**
     * Validate the plugin
     *
     * Checks that the loop helper loaded is an instance of LoopHelper\HelperInterface.
     *
     * @param mixed $plugin
     * @throws InvalidHelperException If invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof HelperInterface) {
            // we're okay
            return;
        }

        throw new InvalidHelperException(
            sprintf(
                'Plugin of type %s is invalid; must implement %s\LoopHelper\HelperInterface',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            )
        );
    }
}
