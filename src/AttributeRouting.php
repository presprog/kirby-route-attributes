<?php declare(strict_types=1);

namespace PresProg\AttributeRouting;

use Kirby\Exception\InvalidArgumentException;
use Kirby\Toolkit\Dir;
use PresProg\AttributeRouting\Attributes\RouteAttribute;
use ReflectionAttribute;
use ReflectionException;
use ReflectionFunction;

class AttributeRouting
{
    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function registerRoutes(): void
    {
        kirby()->extend([
            'routes' => self::loadRoutes()
        ]);
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    private static function loadRoutes(): array
    {
        $cache = kirby()->cache('presprog.attribute-routing');

        if ($cache->exists('routes')) {
            $routeCollection = $cache->get('routes');
        } else {
            $routeCollection = self::loadRoutesFromFiles();
            $cache->set('routes', $routeCollection);
        }

        foreach ($routeCollection as &$route) {
            $action = require $route['file'];
            $route['action'] = function () use ($action) {
                return $action(...func_get_args());
            };
            unset($route['file']);
        }

        return $routeCollection;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private static function loadRoutesFromFiles(): array
    {
        $routes = [];
        $files = Dir::files(kirby()->root('site') . '/routes', null, true);

        foreach ($files as $file) {
            $route = require $file;

            if (!is_array($route) && !is_callable(($route))) {
                throw new \RuntimeException(sprintf('%s must return an array or a function.', $file));
            }

            if (is_array($route)) {
                $routes[] = $route;
            } else {
                $routes[] = self::getRouteMetaData($route, $file);
            }
        }

        return $routes;
    }

    /**
     * @throws ReflectionException
     */
    private static function getRouteMetaData(callable $route, string $file): array
    {
        $function = new ReflectionFunction($route);
        $attributes = $function->getAttributes(
            RouteAttribute::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        if (empty($attributes)) {
            return [];
        }

        $attribute = $attributes[0];
        $instance = $attribute->newInstance();

        return [
            'pattern' => $instance->pattern,
            'method' => $instance->method,
            'file' => $file,
        ];
    }
}