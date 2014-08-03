<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\VarTranslator\Operation\OnVar;

/**
 *
 */
class EqualTo implements PluginInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke($value, $expected)
    {
        return $value == $expected;
    }
}
