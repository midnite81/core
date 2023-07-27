<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * This attribute is used to define the output format of a Carbon instance on a class property
 * When used with BaseEntity, it will automatically format the property when it is outputted via toArray() or toJson()
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
