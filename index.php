<?php declare(strict_types=1);

// Only used when plugin is installed manually via ZIP or GIT submodule.
@include_once __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App;
use PresProg\RouteAttributes\RouteAttributes;

App::plugin('presprog/route-attributes', [
    'options' => [
        'cache' => true,
    ],
    'hooks' => [
        'system.loadPlugins:after' => function () {
            RouteAttributes::registerRoutes();
        }
    ]
]);
