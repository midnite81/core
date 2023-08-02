<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes\MagicMethods\Getters;

use Attribute;

/**
 * Attribute that marks a class property as accessible via magic methods.
 *
 * This attribute can be applied to class properties that should be accessible using magic methods
 * (e.g., __get()) in order to allow dynamic access to the property.
 *
 * This attribute is designed to be used with the Getter, or GetterAndSetter, Trait
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CanAccessViaMagicMethod
{
}
