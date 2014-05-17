<?php

namespace WebinoDraw\Manipulator;

use WebinoDraw\Stdlib\VarTranslator;
use Zend\Stdlib\PriorityQueue;

/**
 *
 */
class Manipulator
{
    /**
     *
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @var PriorityQueue
     */
    protected $plugins;

    /**
     *
     */
    public function __construct(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        $this->plugins       = new PriorityQueue;
    }

    /**
     * @param Plugin\PluginInterface $plugin
     * @param int $priority
     */
    public function setPlugin(Plugin\PluginInterface $plugin, $priority = 1)
    {
        $this->plugins->insert($plugin, $priority);
        return $this;
    }

    public function manipulate(array $options)
    {
        $arg = $this->createPluginArgument($options);

        $this->eachPlugin(
            __NAMESPACE__ . '\Plugin\PreLoopPluginInterface',
            function ($plugin) use ($arg) {
                $plugin->preLoop($arg);
            }
        );

        if ($arg->isManipulationStopped()) {
            return;
        }

        foreach ($arg->getNodes() as $node) {
            $this->eachPlugin(
                __NAMESPACE__ . '\Plugin\InLoopPluginInterface',
                function ($plugin) use ($node, $arg) {
                    $plugin->inLoop($node, $arg);
                }
            );

            if ($arg->isManipulationStopped()) {
                return;
            }
        }

        $this->eachPlugin(
            __NAMESPACE__ . '\Plugin\PostLoopPluginInterface',
            function ($plugin) use ($arg) {
                $plugin->postLoop($arg);
            }
        );

        return $this;
    }

    protected function createPluginArgument(array $options)
    {
        return new Plugin\PluginArgument($options);
    }

    protected function eachPlugin($className, callable $callback)
    {
        foreach ($this->plugins as $plugin) {
            !is_subclass_of($plugin, $className) or
                $callback($plugin);
        }
        return $this;
    }
}
