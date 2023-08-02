<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes\MagicMethods\Getters;

use Attribute;

/**
 * Attribute that marks a class as requiring explicit `CanAccessViaMagicMethod` attribute
 * for dynamically getting properties via magic methods.
 *
 * When applied to a class, this attribute indicates that properties must be explicitly marked
 * with the CanAccessViaMagicMethod attribute in order to be retrieved via magic methods (e.g., __get()).
 */
#[Attribute(Attribute::TARGET_CLASS)]
class MagicMethodGetExplicit
{
}
