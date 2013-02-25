#!/usr/bin/env php
<?php

use Zend\Di\Definition\CompilerDefinition;

// Autoloader
$loader = require __DIR__ . '/../._test/ZendSkeletonApplication/vendor/autoload.php';

$loader->add('WebinoDraw', __DIR__ . '/../src');

// Compile Di Definition
$diCompiler = new CompilerDefinition;

$diCompiler->addDirectory(__DIR__ . '/../src');

$diCompiler->compile();

$definition = $diCompiler->toArrayDefinition()->toArray();

$dir = __DIR__ . '/../data/di';

is_dir($dir) or mkdir($dir);

file_put_contents(
    $dir . '/definition.php',
    '<?php ' . PHP_EOL . 'return ' . var_export($definition, true) . ';' . PHP_EOL
);