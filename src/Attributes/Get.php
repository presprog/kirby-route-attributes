<?php declare(strict_types=1);

namespace PresProg\AttributeRouting\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_FUNCTION)]
class Get implements RouteAttribute
{
    public function __construct(
        public string $pattern
    ) {}
}