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

use Zend\Code\Scanner\FileScanner as CodeFileScanner;
use Zend\Di\Definition\CompilerDefinition;

// Autoloader
$vendorDir = __DIR__ . '/../vendor';
$loader    = require $vendorDir . '/autoload.php';
$loader->add(__NAMESPACE__, __DIR__ . '/../src');

// Compile Di Definition
$diCompiler = new CompilerDefinition;
$diCompiler->addDirectory(__DIR__ . '/../src');

foreach ([
    // add files
    $vendorDir . '/zendframework/zendframework/library/Zend/Form/Factory.php',

] as $file) {
    $diCompiler->addCodeScannerFile(new CodeFileScanner($file));
}

$diCompiler->compile();
$definition = $diCompiler->toArrayDefinition()->toArray();

$dir = __DIR__ . '/../data/di';
is_dir($dir) or mkdir($dir);

file_put_contents(
    $dir . '/definition.php',
    '<?php ' . PHP_EOL . 'return ' . var_export($definition, true) . ';' . PHP_EOL
);
