<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * This attribute is used to define the format of a Carbon instance on a class property
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CarbonFormat
{
    public function __construct(public string $format)
    {
    }
}
