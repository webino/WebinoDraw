#!/usr/bin/env php
<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw;

use WebinoDev\Di\Definition\Generator;

// Autoloader
require __DIR__ . '/../tests/resources/init_autoloader.php';

// Dump DI definition
(new Generator(__DIR__))->compile([
    '/zendframework/zendframework/library/Zend/Form/Factory.php',
    '/zendframework/zendframework/library/Zend/Form/View/Helper/FormCollection.php',
    '/zendframework/zendframework/library/Zend/Form/View/Helper/FormElement.php',
    '/zendframework/zendframework/library/Zend/Form/View/Helper/FormRow.php',
    '/zendframework/zendframework/library/Zend/Filter/FilterPluginManager.php',
    '/zendframework/zendframework/library/Zend/View/HelperPluginManager.php',
    '/zendframework/zendframework/library/Zend/View/Helper/BasePath.php',
    '/zendframework/zendframework/library/Zend/View/Helper/EscapeHtml.php',
    '/zendframework/zendframework/library/Zend/View/Helper/ServerUrl.php',
])->dump();
