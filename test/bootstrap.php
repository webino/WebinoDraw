<?php

use WebinoDrawTest\TestCase;
use Zend\Loader\StandardAutoloader;

chdir(__DIR__);

$autoloader = array(
    __DIR__ . '/../../../autoload.php',
    __DIR__ . '/../../../vendor/autoload.php',
    'autoload.php',
);

foreach ($autoloader as $path) {
    $loader = @include $path;
    if ($loader) break;
}

if (!class_exists('Composer\Autoload\ClassLoader')) {
    throw new RuntimeException('Unable to load. Run `php composer.phar install`.');
}

$loader->add('WebinoDraw', __DIR__ . '/../src');
$loader->add('WebinoDrawTest', __DIR__ .  '/../test');
