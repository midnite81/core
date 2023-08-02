<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Entities;

use Midnite81\Core\Attributes\MagicMethods\Setters\CannotBeSetByMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Setters\CanSetViaMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Setters\MagicMethodSetExplicit;
use Midnite81\Core\Exceptions\MagicMethods\CannotBeSetByMagicMethodException;
use Midnite81\Core\Exceptions\MagicMethods\PropertyRequiresCanSetViaMagicMethodAttributeException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * FluentSetters Trait
 *
 * This trait provides the ability to set properties dynamically through magic methods like __set()
 * and __call(). However, the author does not advocate the extensive use of magic methods and prefers
 * strongly typed methods whenever possible. The use of magic methods should be considered carefully
 * to maintain code readability and prevent potential issues that may arise due to dynamic behavior.
 *
 * The trait is designed to offer a flexible approach for setting properties dynamically, but it also
 * enforces certain rules through attribute checks to ensure the safety and consistency of the code.
 */
trait FluentSetters
{
    /**
     * Magic method to set properties dynamically
     *
     * @param string $name
     * @param mixed $value
     *
     * @throws CannotBeSetByMagicMethodException
     * @throws PropertyRequiresCanSetViaMagicMethodAttributeException
     * @throws ReflectionException
     */
    public function __set(string $name, mixed $value)
    {
        // Use the internal method to handle property setting.
        $this->fluentSettersSet($name, $value);
    }

    /**
     * Magic method to handle dynamic setter methods like setName(), setAge(), etc.
     *
     * @param string $method
     * @param array $arguments
     * @return $this
     *
     * @throws PropertyRequiresCanSetViaMagicMethodAttributeException
     * @throws ReflectionException
     * @throws CannotBeSetByMagicMethodException
     */
    public function __call(string $method, array $arguments): static
    {
        // Use the internal method to handle dynamic getter methods.
        return $this->fluentSetterCall($method, $arguments);
    }

    /**
     * Set a property value dynamically
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     *
     * @throws CannotBeSetByMagicMethodException
     * @throws PropertyRequiresCanSetViaMagicMethodAttributeException
     * @throws ReflectionException
     */
    public function fluentSettersSet(string $name, mixed $value): static
    {
        // Call the internal method to handle property setting.
        $this->internalSetProperty($name, $value);

        return $this;
    }

    /**
     * Handle dynamic setter methods
     *
     * @param string $method
     * @param array $arguments
     * @return $this
     *
     * @throws CannotBeSetByMagicMethodException
     * @throws PropertyRequiresCanSetViaMagicMethodAttributeException
     * @throws ReflectionException
     */
    public function fluentSetterCall(string $method, array $arguments): static
    {
        // Remove "set" prefix and make the first letter lowercase.
        $property = lcfirst(substr($method, 3));

        // Check if the method starts with "set" and the property exists in the class.
        if (str_starts_with($method, 'set') && property_exists($this, $property)) {
            // Call the internal method to handle property setting.
            $this->internalSetProperty($property, $arguments[0]);

            return $this;
        }

        // If the method is not recognized as a dynamic setter or the property doesn't exist, throw an exception.
        throw new \BadMethodCallException("Call to undefined method {$method}()");
    }

    /**
     * Set a property explicitly
     *
     * @param string $propertyName
     * @param mixed $value
     * @return void
     *
     * @throws PropertyRequiresCanSetViaMagicMethodAttributeException
     * @throws CannotBeSetByMagicMethodException
     * @throws ReflectionException
     */
    protected function internalSetProperty(string $propertyName, mixed $value): void
    {
        // Get the reflection class of the current object.
        $reflectionClass = new ReflectionClass($this);

        // Check if the class has the MagicMethodSetExplicit attribute.
        $hasMagicMethodSetExplicit = !empty($reflectionClass->getAttributes(MagicMethodSetExplicit::class));

        // Get the reflection property for the specified property name.
        $reflectionProperty = new ReflectionProperty($this, $propertyName);

        // Check if the property has the CanSetViaMagicMethod and CannotBeSetByMagicMethod attributes.
        $canSetViaMagicMethod = !empty($reflectionProperty->getAttributes(CanSetViaMagicMethod::class));
        $cannotSetViaMagicMethod = !empty($reflectionProperty->getAttributes(CannotBeSetByMagicMethod::class));

        if ($hasMagicMethodSetExplicit) {
            // If the class has the MagicMethodSetExplicit attribute, check if the property
            // requires the CanSetViaMagicMethod attribute to be set using magic methods.
            if (!$canSetViaMagicMethod || $cannotSetViaMagicMethod) {
                // If the property does not have the CanSetViaMagicMethod attribute, throw an exception.
                throw new PropertyRequiresCanSetViaMagicMethodAttributeException($propertyName);
            }
        } else {
            // If the class does not have the MagicMethodSetExplicit attribute, check if the property
            // has the CannotBeSetByMagicMethod attribute, indicating it cannot be set using magic methods.
            if ($cannotSetViaMagicMethod) {
                // If the property has the CannotBeSetByMagicMethod attribute, throw an exception.
                throw new CannotBeSetByMagicMethodException($propertyName);
            }
        }

        // Set the property value using the magic method.
        $this->$propertyName = $value;
    }
}
