<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * This attribute is used to define a class as requiring all properties to be initialised
 *
 * @Annotation
 *
 * @Target({"CLASS"})
 */
#[Attribute(Attribute::TARGET_CLASS)]
class PropertiesMustBeInitialised
{
}
