<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Entities;

use Midnite81\Core\Attributes\MagicMethods\Getters\CanAccessViaMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Getters\CannotGetByMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Getters\MagicMethodGetExplicit;
use Midnite81\Core\Exceptions\MagicMethods\CannotGetByMagicMethodException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Getters Trait
 *
 * This trait provides the ability to get properties dynamically through magic methods like __get()
 * and __call(). However, the author expresses a belief that the use of magic methods should be approached
 * with caution, and strongly suggests favoring strongly typed methods whenever possible. The extensive
 * reliance on magic methods may lead to code readability and maintainability issues.
 *
 * The trait is designed to offer a flexible approach for getting properties dynamically, but it also
 * enforces certain rules through attribute checks to ensure the safety and consistency of the code.
 */
trait Getters
{
    /**
     * Magic method to get properties dynamically
     *
     * @param string $name
     * @return mixed
     *
     * @throws CannotGetByMagicMethodException
     * @throws ReflectionException
     */
    public function __get(string $name)
    {
        // Use the internal method to handle property getting.
        return $this->fluentGetterGet($name);
    }

    /**
     * Magic method to handle dynamic getter methods like getName(), getAge(), etc.
     *
     * @param string $method
     * @param array $arguments
     * @return $this
     *
     * @throws CannotGetByMagicMethodException
     * @throws ReflectionException
     */
    public function __call(string $method, array $arguments)
    {
        // Use the internal method to handle property getting.
        return $this->fluentGettersCall($method, $arguments);
    }

    /**
     * Get a property value dynamically
     *
     * @param string $property
     * @return mixed
     *
     * @throws CannotGetByMagicMethodException
     * @throws ReflectionException
     */
    public function fluentGetterGet(string $property): mixed
    {
        // Call the internal method to handle property getting.
        return $this->internalGetProperty($property);
    }

    /**
     * Handle dynamic getter methods
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     *
     * @throws CannotGetByMagicMethodException
     * @throws ReflectionException
     */
    public function fluentGettersCall(string $method, array $arguments): mixed
    {
        // Remove "get" prefix and make the first letter lowercase.
        $property = lcfirst(substr($method, 3));

        // Check if the method starts with "get" and the property exists in the class.
        if (str_starts_with($method, 'get') && property_exists($this, $property)) {
            // Call the internal method to handle property getting.
            return $this->internalGetProperty($property);
        }

        // If the method is not recognized as a dynamic getter or the property doesn't exist, throw an exception.
        throw new \BadMethodCallException("Call to undefined method {$method}()");
    }

    /**
     * Get a property value explicitly
     *
     * @param string $propertyName
     * @return mixed
     *
     * @throws CannotGetByMagicMethodException
     * @throws ReflectionException
     */
    protected function internalGetProperty(string $propertyName): mixed
    {
        // Get a reflection property for the specified property name.
        $reflectionProperty = new ReflectionProperty($this, $propertyName);

        // Check if the class has the MagicMethodGetExplicit attribute.
        $reflectionClass = new ReflectionClass($this);
        $hasMagicMethodGetExplicit = !empty($reflectionClass->getAttributes(MagicMethodGetExplicit::class));

        if ($hasMagicMethodGetExplicit) {
            // If MagicMethodGetExplicit attribute is present on the class,
            // check if the property is explicitly marked with the CanAccessViaMagicMethod attribute.
            $canAccess = !empty($reflectionProperty->getAttributes(CanAccessViaMagicMethod::class));

            if (!$canAccess) {
                // If the property does not have the CanAccessViaMagicMethod attribute, throw an exception.
                throw new CannotGetByMagicMethodException($propertyName);
            }
        } else {
            // If the class does not have the MagicMethodGetExplicit attribute,
            // check if the property has the CannotGetByMagicMethodException attribute,
            // indicating it cannot be accessed using magic methods.
            $cannotAccess = !empty($reflectionProperty->getAttributes(CannotGetByMagicMethod::class));

            if ($cannotAccess) {
                // If the property has the CannotGetByMagicMethodException attribute, throw an exception.
                throw new CannotGetByMagicMethodException($propertyName);
            }
        }

        // Return the value of the property.
        return $this->$propertyName;
    }
}
