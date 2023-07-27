<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * Specifies the desired timezone for a Carbon instance stored in a class property.
 *
 * This attribute is used to indicate the desired timezone for a Carbon instance that is stored in a class property.
 * When used in conjunction with BaseEntity, it will automatically convert the timezone when the property is
 * outputted via toArray() or toJson().
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class TimeZone
{
    /**
     * The desired timezone represented as a string.
     *
     * @param string $timezone The desired timezone represented as a string.
     */
    public function __construct(public string $timezone)
    {
    }
}
