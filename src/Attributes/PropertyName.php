<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * This attribute is used to define the name of a property (as opposed to the name of the property in the class)
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyName
{
    public function __construct(public string $name)
    {
    }
}
