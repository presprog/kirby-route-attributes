<?php declare(strict_types=1);

namespace PresProg\AttributeRouting;

use Kirby\Cache\Cache;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Toolkit\Dir;
use PresProg\AttributeRouting\Attributes\RouteAttribute;
use ReflectionAttribute;
use ReflectionException;
use ReflectionFunction;

class AttributeRouting
{
    private Cache $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function registerRoutes(): void
    {
        $self = new self(
            kirby()->cache('presprog.attribute-routing')
        );

        kirby()->extend([
            'routes' => $self->loadRoutes()
        ]);
    }

    /**
     * @throws ReflectionException
     */
    private function loadRoutes(): array
    {
        if ($this->cache->exists('routes')) {
            $routeCollection = $this->cache->get('routes');
        } else {
            $routeCollection = $this->loadRoutesFromFiles();
            $this->cache->set('routes', $routeCollection);
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
    private function loadRoutesFromFiles(): array
    {
        $routes = [];
        $files = Dir::files(kirby()->root('site') . '/routes', null, true);

        foreach ($files as $file) {
            $route = require $file;

            if (!is_callable(($route))) {
                throw new \RuntimeException(sprintf('%s must return a callable.', $file));
            }

            $routes[] = $this->getRouteMetaData($route, $file);
        }

        return $routes;
    }

    /**
     * @throws ReflectionException
     */
    private function getRouteMetaData(callable $route, string $file): array
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