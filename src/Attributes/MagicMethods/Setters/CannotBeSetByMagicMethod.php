<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes\MagicMethods\Setters;

use Attribute;

/**
 * Attribute that marks a class property as not being settable by magic methods.
 *
 * This attribute can be applied to class properties that should not be set using magic methods
 * (e.g., __set()) in order to enforce strict control over property access.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CannotBeSetByMagicMethod {}
