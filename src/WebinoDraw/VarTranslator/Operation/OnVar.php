<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\VarTranslator\Operation;

use ArrayAccess;
use WebinoDraw\VarTranslator\Operation\OnVar\PluginInterface;
use Zend\Stdlib\PriorityQueue;

/**
 *
 */
class OnVar
{
    /**
     * @var PriorityQueue
     */
    protected $plugins;

    /**
     */
    public function __construct()
    {
        $this->plugins = new PriorityQueue;
    }

    /**
     * @param PluginInterface $plugin
     * @param int $priority
     */
    public function setPlugin(PluginInterface $plugin, $priority = 1)
    {
        $this->plugins->insert($plugin, $priority);
        return $this;
    }

    /**
     * @param ArrayAccess $varTranslation
     * @param array $spec
     * @param callable $callback
     * @return self
     * @throws Exception\InvalidInstructionException
     */
    public function apply(ArrayAccess $varTranslation, array $spec, callable $callback)
    {
        foreach ($spec as $spec) {
            if (!array_key_exists('var', $spec)) {
                throw new Exception\InvalidInstructionException(
                    'Expected `var` option in ' . print_r($spec, true)
                );
            }

            $this->invokePlugins($varTranslation, $spec, $callback);
        }

        return $this;
    }

    /**
     * @param ArrayAccess $varTranslation
     * @param array $spec
     * @param callable $callback
     * @return self
     */
    protected function invokePlugins(ArrayAccess $varTranslation, array $spec, callable $callback)
    {
        $value = $varTranslation->removeVars($varTranslation->translateString($spec['var']));
        foreach ($this->plugins as $plugin) {
            $pluginKey = lcfirst(substr(strrchr(get_class($plugin), "\\"), 1));
            if (!array_key_exists($pluginKey, $spec)) {
                continue;
            }

            $expected = $varTranslation->removeVars($varTranslation->translateString($spec[$pluginKey]));
            $this->fixTypes($value, $expected);
            !$plugin($value, $expected) or $callback($spec);
        }

        return $this;
    }

    /**
     * Fix value types for equation
     *
     * @param mixed $valA
     * @param mixed $valB
     * @return self
     */
    private function fixTypes(&$valA, &$valB)
    {
        if (empty($valA) && is_array($valA)) {
            $valA = (string) null;
            $valB = (string) $valB;
            return $this;
        }
        if (is_numeric($valA)) {
            $valA = (float) $valA;
            $valB = (float) $valB;
            return $this;
        }
        if (is_string($valA)) {
            $valA = (string) $valA;
            $valB = (string) $valB;
            return $this;
        }

        return $this;
    }
}
