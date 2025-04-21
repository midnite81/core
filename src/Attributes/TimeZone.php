<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The TimeZone attribute is designed to specify the desired timezone for Carbon date instances within a class property.
 * This is particularly useful for applications that operate across multiple timezones and require consistent
 * timezone handling for date and time representations. When a class property is annotated with this attribute,
 * it directs the BaseEntity class (or similar foundational classes equipped with serialization capabilities)
 * to automatically adjust the Carbon instance's timezone to the specified value upon serialization.
 *
 * This automatic conversion is applied when the property is serialized to array or JSON formats using
 * the BaseEntity's serialization methods (e.g., toArray() or toJson()). The attribute ensures that date
 * and time information is accurately represented in the desired timezone for external interfaces or data
 * exchanges, enhancing the application's interoperability and data consistency.
 *
 * Intended usage:
 * This attribute is intended for use with classes extending BaseEntity or similar base classes that
 * provide automated property serialization. It is especially beneficial in scenarios where the application's
 * domain model includes date and time information that must be consistently represented in a specific timezone
 * across various parts of the application or in communication with external systems.
 *
 * Example usage within a class extending BaseEntity:
 * #[TimeZone('Europe/London')]
 * private Carbon\Carbon $eventTime;
 *
 * In this example, when the `eventTime` property is serialized using BaseEntity's methods, its timezone
 * will be automatically converted to 'Europe/London', ensuring the serialized output reflects the correct
 * time for that timezone.
 *
 * Note: To effectively leverage this attribute, the BaseEntity class or similar must implement logic to
 * recognize and apply the specified timezone during the serialization process. This attribute acts as
 * a declarative tool to signal the desired timezone conversion, and its actual application depends on
 * the base class's support for such attribute-driven behavior.
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class TimeZone
{
    /**
     * Constructs a new TimeZone attribute instance.
     *
     * @param string $timezone The desired timezone, represented as a string, to be applied to the Carbon instance.
     */
    public function __construct(public string $timezone) {}
}
