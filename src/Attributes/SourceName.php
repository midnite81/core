<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The SourceName attribute is designed to specify an alternate name for a property, primarily
 * for use during the property mapping process within classes that inherit from BaseEntity or
 * similar foundational classes. This attribute enables the mapping of class properties to fields
 * that may have different names in external data sources, such as databases, APIs, or JSON payloads,
 * thereby facilitating seamless data integration and translation.
 *
 * When a class property is annotated with SourceName, it instructs the automatic property mapping
 * logic in BaseEntity to associate the property with the specified 'source name' rather than the
 * property's name within the class. This allows developers to maintain clean and consistent domain
 * models while still being able to work with external data sources that follow different naming
 * conventions.
 *
 * The intended use of this attribute is in conjunction with BaseEntity's automatic property mapping
 * capabilities. BaseEntity, or similar base classes, should be designed to recognize and utilize
 * the SourceName attribute during serialization and deserialization processes, ensuring that data
 * is correctly mapped to and from the class properties based on the attribute's specifications.
 *
 * Example usage within a class extending BaseEntity:
 * #[SourceName('external_field_name')]
 * private $internalPropertyName;
 *
 * In this example, the `internalPropertyName` property will be mapped to 'external_field_name'
 * when the class instance is serialized or deserialized, allowing the internal property to
 * correspond directly with an external data field named 'external_field_name'.
 *
 * Note: For the SourceName attribute to be effective, the BaseEntity class or the base class
 * handling property mapping must implement logic to interpret and apply the alternate names
 * specified by this attribute during the mapping process. This attribute acts as a formal
 * declaration for alternative property naming in the context of data interchange.
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SourceName
{
    public function __construct(public string $name) {}
}
