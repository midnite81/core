<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The CarbonFormat attribute specifies the desired format for properties within a class that are
 * instances of the Carbon\Carbon date library. This attribute is designed for use in classes that
 * inherit from BaseEntity or a similar base class that provides automatic serialization capabilities,
 * such as converting object properties to arrays or JSON (e.g., through toArray() or toJson() methods).
 *
 * When applied to a class property, this attribute instructs the BaseEntity serialization logic to
 * format the Carbon instance using the specified format string upon serialization. This ensures
 * consistent date formatting across the application's outputs, particularly useful for API responses
 * or other data exports that require a specific date format.
 *
 * The format string should adhere to the date format standards used by PHP's `date()` function,
 * allowing for flexible date representation.
 *
 * Example usage within a class extending BaseEntity:
 * #[CarbonFormat('Y-m-d H:i:s')]
 * public Carbon\Carbon $createdAt;
 *
 * In this example, the `createdAt` property will be automatically formatted to 'Y-m-d H:i:s' when
 * the containing object is serialized using BaseEntity's serialization methods. This functionality
 * simplifies date formatting in serialized outputs, ensuring that dates are presented in a consistent
 * and expected format across your application.
 *
 * Note: The effectiveness of this attribute is contingent upon its integration within the serialization
 * logic of BaseEntity or a similar base class. Ensure that your base class is equipped to interpret
 * and apply the formatting specified by this attribute during serialization processes.
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CarbonFormat
{
    public function __construct(public string $format)
    {
    }
}
