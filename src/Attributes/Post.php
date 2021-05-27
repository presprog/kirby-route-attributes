<?php declare(strict_types=1);

namespace PresProg\AttributeRouting\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_FUNCTION)]
class Post extends Route
{
    public function __construct(string $pattern, ) {
        parent::__construct($pattern, 'POST');
    }
}