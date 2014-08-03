<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Config;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

/**
 * Used in configs to automatically load the drawsets
 */
class InstructionsetAutoloader
{
    const CFG_SUFFIX          = '.php';
    const DRAW_DIR_NAME       = 'draw';
    const DRAW_SET_CFG_SUFFIX = '.drawset';

    /**
     * @var string
     */
    protected $dir;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @param string $dir
     * @param string $namespace
     */
    public function __construct($dir, $namespace)
    {
        $this->dir       = $dir;
        $this->namespace = $namespace;
    }

    /**
     * @return array
     */
    public function load()
    {
        $dir      = $this->dir . '/' . self::DRAW_DIR_NAME;
        $iterator = $this->createDirIterator($dir);

        $config = [];
        foreach ($iterator as $path) {
            $index = join(
                '/',
                array_filter([
                    $this->namespace,
                    trim(dirname(str_replace($dir, '', $path[0])), '/'),
                    substr(pathinfo($path[0])['filename'], 0, - strlen(self::DRAW_SET_CFG_SUFFIX)),
                ])
            );
            $config[$index] = require $path[0];
        }

        return $config;
    }

    /**
     * @param string $dir
     * @return RegexIterator
     */
    private function createDirIterator($dir)
    {
        return new RegexIterator(
            new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)),
            '/^.+' . preg_quote(self::DRAW_SET_CFG_SUFFIX) . preg_quote(self::CFG_SUFFIX) . '$/i',
            RecursiveRegexIterator::GET_MATCH
        );
    }
}
