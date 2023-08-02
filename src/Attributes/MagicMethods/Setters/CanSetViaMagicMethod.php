<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes\MagicMethods\Setters;

use Attribute;

/**
 * Attribute that marks a class property as accessible via magic methods.
 *
 * This attribute can be applied to class properties that should be accessible using magic methods
 * (e.g., __get()) in order to allow dynamic access to the property.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CanSetViaMagicMethod
{
}
