<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The PropertiesMustBeInitialised attribute is intended for use with classes that inherit from
 * BaseEntity or a similar foundational class. It marks a class as requiring all properties to be
 * initialised to ensure the completeness and integrity of the object's state. This attribute acts
 * as a declarative tool to indicate that instances of the annotated class must have all their
 * properties explicitly initialised, either through direct assignment, in the constructor, or
 * through default property values.
 *
 * Applying this attribute to a class signals to developers, and potentially to static analysis
 * tools, the requirement for complete initialisation of properties. This is crucial for entities,
 * data transfer objects (DTOs), and other similar classes managed by BaseEntity, where a fully
 * initialised object state is essential for the correct operation and data integrity.
 *
 * While this attribute itself does not enforce initialisation at runtime, it serves to highlight
 * the importance of initialisation within the development process, particularly in the context of
 * classes extending BaseEntity. BaseEntity or similar classes should implement logic to check
 * and enforce the initialisation of properties as required by this attribute, enhancing the
 * robustness and reliability of the application.
 *
 * Example usage within a class extending BaseEntity:
 * #[PropertiesMustBeInitialised]
 * class MyClass extends BaseEntity {
 *     private $property1;
 *     private $property2;
 *
 *     public function __construct() {
 *         $this->property1 = 'value1';
 *         $this->property2 = 'value2';
 *     }
 * }
 *
 * This example demonstrates MyClass, which extends BaseEntity, marked to require all its
 * properties to be initialised. The constructor ensures that `property1` and `property2` are
 * initialised upon instance creation, adhering to the attribute's requirement.
 *
 * Note: The enforcement of property initialisation should be integrated within the BaseEntity's
 * construction or initialisation logic, or ensured through static analysis tools. This attribute
 * serves as a formal declaration of the initialisation requirement for properties.
 *
 * @Annotation
 *
 * @Target({"CLASS"})
 */
#[Attribute(Attribute::TARGET_CLASS)]
class PropertiesMustBeInitialised
{
}
