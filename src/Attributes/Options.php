<?php declare(strict_types=1);

namespace PresProg\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_FUNCTION | Attribute::TARGET_METHOD)]
class Options extends Route
{
    public function __construct(string $pattern) {
        parent::__construct($pattern, 'OPTIONS');
    }
}
