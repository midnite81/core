<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * This attribute is used to define the original name of a property (as opposed to the name of the property in the class)
 * When used with BaseEntity, when automatically mapping properties, it will use the original name to map to the property
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SourceName
{
    public function __construct(public string $name)
    {
    }
}
