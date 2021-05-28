<?php declare(strict_types=1);

namespace PresProg\AttributeRouting\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_FUNCTION | Attribute::TARGET_METHOD)]
class Patch extends Route
{
    public function __construct(string $pattern) {
        parent::__construct($pattern, 'PATCH');
    }
}