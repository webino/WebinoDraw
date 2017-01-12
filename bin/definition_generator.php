#!/usr/bin/env php
<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use WebinoDev\Di\Definition\Generator;

// TODO: remove this file, the DI is deprecated
require __DIR__ . '/../tests/resources/init_autoloader.php';
(new Generator(__DIR__))->compile()->dump();
