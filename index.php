<?php declare(strict_types=1);

use PresProg\AttributeRouting\AttributeRouting;

require __DIR__ . '/vendor/autoload.php';

\Kirby\Cms\App::plugin('presprog/attribute-routing', [
    'hooks' => [
        'system.loadPlugins:after' => function () {
            AttributeRouting::loadRoutes();
        }
    ]
]);