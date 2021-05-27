<?php declare(strict_types=1);

namespace PresProg\AttributeRouting;

use PresProg\AttributeRouting\Attributes\RouteAttribute;
use Reflection;
use ReflectionFunction;

class AttributeRouting
{
    public static function loadRoutes()
    {
        $routes = self::loadRoutesFromAttributes();

        kirby()->extend([
            'routes' => $routes
        ]);
    }

    private static function loadRoutesFromAttributes()
    {
        $siteFolder = kirby()->root('site');
        $route = require $siteFolder . '/routes/route.php';

        $refl = new ReflectionFunction($route);
        $attributes = $refl->getAttributes(RouteAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);
        var_dump($attributes[0]);
        die();
    }
}