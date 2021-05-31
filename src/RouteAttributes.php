<?php declare(strict_types=1);

namespace PresProg\RouteAttributes;

use Kirby\Cache\Cache;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Toolkit\Dir;
use PresProg\RouteAttributes\Attributes\RouteAttribute;
use ReflectionAttribute;
use ReflectionException;
use ReflectionFunction;
use RuntimeException;

class RouteAttributes
{
    private Cache $cache;
    private bool $debug;

    public function __construct(Cache $cache, bool $debug)
    {
        $this->cache = $cache;
        $this->debug = $debug;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function registerRoutes(): void
    {
        $self = new self(
            kirby()->cache('presprog.route-attributes'),
            kirby()->option('debug', false)
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
        if (!$this->debug && $this->cache->exists('routes')) {
            $routes = $this->cache->get('routes');
        } else {
            $routes = $this->loadRoutesFromFiles();
            if (!$this->debug) {
                $this->cache->set('routes', $routes);
            }
        }

        foreach ($routes as &$route) {
            $action = require $route['file'];
            $route['action'] = function () use ($action) {
                return $action(...func_get_args());
            };
            unset($route['file']);
        }

        return $routes;
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
                throw new RuntimeException(sprintf('%s must return a callable.', $file));
            }

            $routes[] = $this->getRouteMetaData($route, $file);
        }

        return $routes;
    }

    /**
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function getRouteMetaData(callable $route, string $file): array
    {
        $function = new ReflectionFunction($route);
        $attributes = $function->getAttributes(
            RouteAttribute::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        if (empty($attributes)) {
            throw new RuntimeException('Routes defined in /site/routes/*.php must be annotated with attributes. See PresProg\RouteAttributes\Attributes for available attributes.');
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
