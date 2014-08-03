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

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

/**
 * Static configuration helper
 */
abstract class Config
{
    const CFG_SUFFIX = '.php';
    const DRAW_DIR_NAME   = 'draw';
    const DRAW_SET_CFG_SUFFIX = '.drawset';

    /**
     * Instructionset autoloading
     *
     * @param string $dir
     * @param string $namespace
     * @return array
     */
    public static function instructionsetAutoload($dir, $namespace)
    {
        $drawDir  = $dir . '/' . self::DRAW_DIR_NAME;
        $iterator = new RegexIterator(
            new RecursiveIteratorIterator(new RecursiveDirectoryIterator($drawDir)),
            '/^.+' . preg_quote(self::DRAW_SET_CFG_SUFFIX) . preg_quote(self::CFG_SUFFIX) . '$/i',
            RecursiveRegexIterator::GET_MATCH
        );

        $config = [];
        foreach ($iterator as $path) {
            $finfo = pathinfo($path[0]);
            $index = join(
                '/',
                array_filter([
                    $namespace,
                    trim(dirname(str_replace($drawDir, '', $path[0])), '/'),
                    substr($finfo['filename'], 0, - strlen(self::DRAW_SET_CFG_SUFFIX)),
                ])
            );

            $config[$index] = include $path[0];
        }

        return $config;
    }
}
