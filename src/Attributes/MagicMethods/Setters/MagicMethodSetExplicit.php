<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes\MagicMethods\Setters;

use Attribute;

/**
 * Attribute that marks properties as requiring explicit `CanSetViaMagicMethod` attribute
 * for dynamically setting properties via magic methods.
 *
 * This attribute can be applied to class properties to indicate that they must be explicitly marked
 * with the `CanSetViaMagicMethod` attribute in order to be fluently set via magic methods (e.g., __set()).
 */
#[Attribute(Attribute::TARGET_CLASS)]
class MagicMethodSetExplicit {}
