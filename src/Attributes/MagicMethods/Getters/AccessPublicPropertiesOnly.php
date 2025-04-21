<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes\MagicMethods\Getters;

use Attribute;

/**
 * AccessPublicPropertiesOnly Attribute
 *
 * This attribute is used to indicate that the class it is applied to
 * should only allow access to public properties. It is typically used
 * as a magic method attribute to enforce restricted access to properties.
 *
 * This attribute is designed to be used with the Getter, or GetterAndSetter, Trait
 */
#[Attribute(Attribute::TARGET_CLASS)]
class AccessPublicPropertiesOnly {}
