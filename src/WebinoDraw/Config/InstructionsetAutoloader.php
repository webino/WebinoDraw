<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Config;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * Used in configs to automatically load the drawsets
 */
class InstructionsetAutoloader
{
    const DRAWSET_CFG_SUFFIX = '.drawset.php';

    /**
     * @var string
     */
    protected $dir;

    /**
     * @param string $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return array
     */
    public function load()
    {
        $config       = [];
        $dirLength    = strlen($this->dir) + 1;
        $suffixLength = strlen(self::DRAWSET_CFG_SUFFIX);

        foreach ($this->createDirIterator($this->dir) as $path) {

            $relPath   = substr($path[0], $dirLength);
            $namespace = explode('/', $relPath)[0];

            $index = join(
                '/',
                array_filter([
                    $namespace,
                    trim(substr($relPath, strlen($namespace), - $suffixLength), '/'),
                ])
            );

            /** @noinspection PhpIncludeInspection */
            $drawSpec = require $path[0];
            $config[$index] = is_array($drawSpec) ? $drawSpec : $drawSpec->toArray();
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
            '/^.+' . preg_quote(self::DRAWSET_CFG_SUFFIX) . '$/i',
            RegexIterator::GET_MATCH
        );
    }
}
