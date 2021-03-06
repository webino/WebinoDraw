<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator;

use WebinoDraw\Dom\NodeInterface;
use WebinoDraw\Manipulator\Plugin\PluginArgument;
use WebinoDraw\Manipulator\Plugin\PluginInterface;
use WebinoDraw\VarTranslator\VarTranslator;
use Zend\Stdlib\PriorityQueue;

/**
 * Class Manipulator
 */
class Manipulator
{
    /**
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @var PriorityQueue
     */
    protected $plugins;

    /**
     * @param VarTranslator $varTranslator
     */
    public function __construct(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        $this->plugins       = new PriorityQueue;
    }

    /**
     * @param PluginInterface $plugin
     * @param int $priority
     * @return self
     */
    public function setPlugin(PluginInterface $plugin, $priority = 1)
    {
        $this->plugins->insert($plugin, $priority);
        return $this;
    }

    /**
     * @param array $options
     * @return self
     */
    public function manipulate(array $options)
    {
        $arg = $this->createPluginArgument($options);

        $this->eachPlugin(
            Plugin\PreLoopPluginInterface::class,
            function ($plugin) use ($arg) {
                $plugin->preLoop($arg);
            }
        );

        if ($arg->isManipulationStopped()) {
            return $this;
        }

        foreach ($arg->getNodes()->toArray() as $node) {
            if (!($node instanceof NodeInterface) || empty($node->parentNode)) {
                continue;
            }

            $arg->setNode($node);

            $this->eachPlugin(
                Plugin\InLoopPluginInterface::class,
                function ($plugin) use ($arg) {
                    $plugin->inLoop($arg);
                }
            );

            if ($arg->isManipulationStopped()) {
                return $this;
            }
        }

        $this->eachPlugin(
            Plugin\PostLoopPluginInterface::class,
            function ($plugin) use ($arg) {
                $plugin->postLoop($arg);
            }
        );

        return $this;
    }

    /**
     * @param array $options
     * @return PluginArgument
     */
    protected function createPluginArgument(array $options)
    {
        return new PluginArgument($options);
    }

    /**
     * @param string $className
     * @param callable $callback
     * @return self
     */
    protected function eachPlugin($className, callable $callback)
    {
        foreach ($this->plugins as $plugin) {
            is_subclass_of($plugin, $className)
                and $callback($plugin);
        }

        return $this;
    }
}
