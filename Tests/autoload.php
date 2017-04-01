<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

passthru(sprintf('php %s/App/console doctrine:phpcr:init:dbal --drop --env=dev --force', __DIR__));
passthru(sprintf('php %s/App/console doctrine:phpcr:repository:init', __DIR__));

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
