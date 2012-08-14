<?php

use WebinoDrawTest\TestCase;
use Zend\Loader\StandardAutoloader;

chdir(__DIR__);

$vendorAutoload = __DIR__ . '/../../../autoload.php';
if (!is_file($vendorAutoload)) throw new RuntimeException(
    'vendor/autoload.php could not be found. Did you run `php composer.phar install`?'
);

include $vendorAutoload;

$loader = new StandardAutoloader(array(
     StandardAutoloader::LOAD_NS => array(
         'Webino'         => __DIR__ . '/../src/Webino',
         'WebinoDraw'     => __DIR__ . '/../',
         'WebinoDrawTest' => __DIR__ . '/WebinoDrawTest',
     ),
));
$loader->register();

