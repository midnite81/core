<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * The RequiredProperty attribute is utilized to mark a property within a class as required,
 * signifying that the property must be set to a non-null value before the object is considered
 * valid or complete. This attribute is particularly intended for use in classes that inherit
 * from BaseEntity or similar foundational classes, which may implement validation or initialization
 * logic based on the presence of required properties.
 *
 * When a class property is annotated with RequiredProperty, it indicates to the developers,
 * validation mechanisms, or automated processes within BaseEntity that this property must be
 * explicitly initialized—either through direct assignment, constructor parameters, or through
 * setters—prior to using the object in operations such as serialization, persistence, or
 * business logic execution. The primary goal is to ensure data integrity and object consistency
 * by enforcing the initialization of critical properties.
 *
 * This attribute aids in the development of robust domain models by clearly specifying which
 * properties are essential for the object's valid state, thereby reducing the risk of runtime
 * errors due to uninitialized properties and improving the overall reliability of the application.
 *
 * Example usage within a class extending BaseEntity:
 * #[RequiredProperty]
 * private $mandatoryField;
 *
 * In this context, the `mandatoryField` property must be set to a valid value for instances
 * of the class to be considered complete. The enforcement of this requirement should be
 * integrated within the BaseEntity's logic, such as during object construction, property
 * setting, or pre-serialization checks, to validate the presence of required properties.
 *
 * Note: While the RequiredProperty attribute declares a property as essential, the actual
 * enforcement and validation logic must be implemented within the BaseEntity class or through
 * external validation mechanisms. This attribute serves as a formal declaration, guiding the
 * design and usage of the class properties.
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class RequiredProperty
{
}
