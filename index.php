<?php declare(strict_types=1);

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
