<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Test;

use RuntimeException;

/**
 * Initialize vendor autoloader
 */
$loader = @include __DIR__ . '/../../vendor/autoload.php';
if (empty($loader)) {
    throw new RuntimeException('Unable to load. Run `php composer.phar install`.');
}

$loader->add('Application', __DIR__ . '/src');
$loader->add('WebinoDraw', __DIR__ . '/src');
$loader->add('WebinoDraw', __DIR__ . '/../../src');
$loader->add('WebinoDraw', __DIR__ . '/../functional');
$loader->add('WebinoDraw', __DIR__ . '/../selenium');
$loader->add('WebinoDraw', __DIR__ . '/..');
