<?php
// This is global bootstrap for autoloading
use Doctrine\Common\Annotations\AnnotationRegistry;


$loader = require __DIR__ . '/../vendor/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;