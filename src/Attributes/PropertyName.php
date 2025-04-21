<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The PropertyName attribute is designed to specify an alternative name for a class property,
 * primarily for use when serializing or deserializing objects that inherit from BaseEntity or
 * similar foundational classes. This attribute allows developers to map class properties to
 * differently named fields in data sources or targets, such as database columns, JSON payloads,
 * and other external data representations.
 *
 * By applying this attribute to a property, you can define how that property should be named
 * when the object is serialized to an array or JSON, or how it should be recognized during
 * deserialization. This is particularly useful in scenarios where the property names in your
 * application's domain model do not directly match the names used in your external data sources
 * or APIs.
 *
 * Intended for use with classes extending BaseEntity, this attribute informs the serialization
 * and deserialization processes within BaseEntity to use the specified name instead of the
 * property's actual name in the class. This facilitates a flexible mapping strategy that can
 * adapt to various data naming conventions without requiring changes to the class's internal
 * property names.
 *
 * Example usage within a class extending BaseEntity:
 * #[PropertyName('externalPropertyName')]
 * private $internalPropertyName;
 *
 * In this example, when instances of the class are serialized or deserialized, the
 * `internalPropertyName` property will be mapped to or from `externalPropertyName` in the
 * serialized data structure, allowing for seamless integration with external data sources
 * or formats.
 *
 * Note: The actual mapping logic must be implemented in the BaseEntity's serialization and
 * deserialization methods to recognize and apply the alternative names specified by this
 * attribute. It serves as a formal declaration for renaming properties in the context of
 * data interchange.
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyName
{
    public function __construct(public string $name) {}
}
