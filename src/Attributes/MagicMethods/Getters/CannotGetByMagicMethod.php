<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes\MagicMethods\Getters;

use Attribute;

/**
 * Attribute that marks a class property as not being gettable by magic methods.
 *
 * This attribute can be applied to class properties that should not be accessed using magic methods
 * (e.g., __get()) in order to enforce strict control over property access.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CannotGetByMagicMethod
{
}
