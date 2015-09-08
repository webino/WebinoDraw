<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\VarTranslator\Operation;

use WebinoDraw\Exception;
use WebinoDraw\VarTranslator\Operation\OnVar\PluginInterface;
use WebinoDraw\VarTranslator\Translation;

/**
 *
 */
class OnVar
{
    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * @param PluginInterface $plugin
     * @return self
     */
    public function setPlugin(PluginInterface $plugin)
    {
        $key = lcfirst(substr(strrchr(get_class($plugin), "\\"), 1));
        $this->plugins[$key] = $plugin;
        return $this;
    }

    /**
     * @param Translation $varTranslation
     * @param array $spec
     * @param callable $callback
     * @return self
     * @throws Exception\InvalidInstructionException
     */
    public function apply(Translation $varTranslation, array $spec, callable $callback)
    {
        foreach ($spec as $subSpec) {
            if (!array_key_exists('var', $subSpec)) {
                throw new Exception\InvalidInstructionException(
                    'Expected `var` option in ' . print_r($subSpec, true)
                );
            }

            $this->invokePlugins($varTranslation, $subSpec, $callback);
        }

        return $this;
    }

    /**
     * @param Translation $varTranslation
     * @param array $spec
     * @param callable $callback
     * @return self
     */
    protected function invokePlugins(Translation $varTranslation, array $spec, callable $callback)
    {
        $value = $varTranslation->removeVars($varTranslation->translateString($spec['var']));
        $pass  = false;

        foreach ($spec as $key => $subValues) {
            if (null === $subValues) {
                continue;
            }

            foreach ((array) $subValues as $subValue) {

                $isAnd = (0 === strpos($key, 'and'));
                $isAnd and $key = lcfirst(substr($key, 3));

                if (empty($this->plugins[$key])) {
                    continue;
                }

                $expected = $varTranslation->removeVars($varTranslation->translateString($subValue));
                $this->fixTypes($value, $expected);
                $bool = $this->plugins[$key]->__invoke($value, $expected);
                $pass = $isAnd ? $pass && $bool : $pass || $bool;
            }
        }

        $pass and $callback($spec);
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
