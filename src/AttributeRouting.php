<?php declare(strict_types=1);

namespace PresProg\AttributeRouting;

use Kirby\Toolkit\Dir;
use PresProg\AttributeRouting\Attributes\RouteAttribute;
use ReflectionAttribute;
use ReflectionException;
use ReflectionFunction;

class AttributeRouting
{
    /**
     * @throws ReflectionException
     */
    public static function loadRoutes(): void
    {
        $routes = self::loadRoutesFromAttributes();

        kirby()->extend([
            'routes' => $routes
        ]);
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private static function loadRoutesFromAttributes(): array
    {
        $routes = [];
        $files = Dir::files(kirby()->root('site') . '/routes', null, true);

        foreach ($files as $file) {
            $route = require $file;
            $reflection = new ReflectionFunction($route);
            $attributes = $reflection->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF);
            $attribute = $attributes[0];

            $routes[] = [
                'pattern' => $attribute->getArguments()[0],
                'action' => $route
            ];
        }

        return $routes;
    }
}