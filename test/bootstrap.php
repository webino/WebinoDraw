<?php

use WebinoDrawTest\TestCase;
use Zend\Loader\StandardAutoloader;

chdir(__DIR__);

$vendorAutoload = realpath(__DIR__ . '/../../../autoload.php') or
    $vendorAutoload = realpath(__DIR__ . '/../../../vendor/autoload.php');

if (!is_file($vendorAutoload)) throw new RuntimeException(
    'vendor/autoload.php could not be found. Did you run `php composer.phar install`?'
);

include $vendorAutoload;

$loader = new StandardAutoloader(array(
     StandardAutoloader::LOAD_NS => array(
         'WebinoDraw'     => __DIR__ . '/../src/WebinoDraw',
         'WebinoDrawTest' => __DIR__ . '/WebinoDrawTest',
     ),
));
$loader->register();
