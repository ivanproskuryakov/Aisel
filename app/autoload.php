<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

// PHP Fatal error:  Maximum function nesting level of '100' reached
// Set xDebug nesting level to 1000
ini_set('xdebug.max_nesting_level', 1000);

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
