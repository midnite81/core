<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The ArrayOf attribute is used to specify that a class property should be treated as an array
 * containing instances of a specific class. This attribute helps in automatic property mapping
 * and type conversion when hydrating objects from arrays or other data sources when using on
 * BaseEntity.
 *
 * By annotating a property with ArrayOf, you inform the property hydration process that each
 * item within the array assigned to this property should be an instance of the specified class.
 * This is particularly useful for type-safe collections and ensuring proper type conversion
 * and object instantiation during the hydration process.
 *
 * Example usage:
 * #[ArrayOf(\Namespace\To\YourClass::class)]
 * public array $yourProperty;
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayOf
{
    public function __construct(public string $class) {}
}
