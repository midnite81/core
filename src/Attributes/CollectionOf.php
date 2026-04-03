<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The CollectionOf attribute is used to specify that a class property should be treated as a
 * collection containing instances of a specific class when using BaseEntity hydration.
 *
 * Example usage:
 * #[CollectionOf(\Namespace\To\YourClass::class)]
 * public Collection $yourProperty;
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CollectionOf
{
    public function __construct(public string $class) {}
}
