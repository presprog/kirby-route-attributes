<?php declare(strict_types=1);

namespace PresProg\AttributeRouting\Attributes;

use Attribute;

class Route implements RouteAttribute
{
    public function __construct(
        public string $pattern,
        public string $method = ''
    ) {}
}