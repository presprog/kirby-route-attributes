<?php declare(strict_types=1);

use Kirby\Cms\App;
use PresProg\AttributeRouting\AttributeRouting;

App::plugin('presprog/attribute-routing', [
    'options' => [
        'cache' => true,
    ],
    'hooks' => [
        'system.loadPlugins:after' => function () {
            AttributeRouting::registerRoutes();
        }
    ]
]);