<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

use JetBrains\PhpStorm\ArrayShape;
use Midnite81\Core\Exceptions\Entities\PropertyDoesNotExistException;
use Midnite81\Core\Exceptions\Entities\PropertyIsNotInitialisedException;
use Midnite81\Core\Exceptions\Entities\PropertyIsNotPublicException;
use ReflectionProperty;

trait ArrayAccess
{
    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        $info = $this->getPropertyInfo($offset);

        if ($info['exists'] && $info['isPublic'] && $info['isInitialised']) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     *
     * @throws PropertyIsNotPublicException
     * @throws PropertyIsNotInitialisedException
     * @throws PropertyDoesNotExistException
     */
    public function offsetGet($offset): mixed
    {
        $info = $this->getPropertyInfo($offset);

        if (!$info['exists']) {
            throw new PropertyDoesNotExistException($offset);
        }

        if (!$info['isPublic']) {
            throw new PropertyIsNotPublicException($offset);
        }

        if (!$info['isInitialised']) {
            throw new PropertyIsNotInitialisedException($offset);
        }

        return $this->{$info['actual_property_name']};
    }

    /**
     * {@inheritDoc}
     *
     * @throws PropertyIsNotPublicException
     * @throws PropertyDoesNotExistException
     */
    public function offsetSet($offset, $value): void
    {
        $info = $this->getPropertyInfo($offset);

        if (!$info['exists']) {
            throw new PropertyDoesNotExistException($offset);
        }

        if (!$info['isPublic']) {
            throw new PropertyIsNotPublicException($offset);
        }

        $this->{$info['actual_property_name']} = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        $info = $this->getPropertyInfo($offset);

        if ($info['exists'] && $info['isPublic'] && $info['isInitialised']) {
            unset($this->{$info['actual_property_name']});
        }
    }

    /**
     * Get information about a class property.
     *
     * This method provides information about a specified class property, including its existence,
     * accessibility (public/private), initialization status, current value, and its actual property name.
     *
     * @param string $propertyName The name of the property to get information about.
     * @return array An associative array containing property information:
     *               - 'exists' (bool): True if the property exists in the class, False otherwise.
     *               - 'isPublic' (bool): True if the property is public, False otherwise.
     *               - 'isInitialised' (bool): True if the property is initialized, False otherwise.
     *               - 'value' (mixed): The current value of the property (null if not initialized or non-existent).
     *               - 'property_name' (string): The name of the property specified as input.
     *               - 'actual_property_name' (string): The actual property name used internally (if aliasing is used).
     */
    #[ArrayShape([
        'exists' => 'bool',
        'isPublic' => 'bool',
        'isInitialised' => 'bool',
        'value' => 'mixed',
        'property_name' => 'string',
        'actual_property_name' => 'string',
    ])]
    protected function getPropertyInfo(string $propertyName): array
    {
        $reflection = $this->getReflection();
        $properties = collect($reflection->getProperties());
        $actualPropertyName = $propertyName;

        if (!property_exists($this, $propertyName) && array_key_exists($propertyName, $this->internalPropertyNames)) {
            $actualPropertyName = $this->internalPropertyNames[$propertyName];
        }

        $response = [
            'exists' => false,
            'isPublic' => false,
            'isInitialised' => false,
            'value' => null,
            'property_name' => $propertyName,
            'actual_property_name' => $actualPropertyName,
        ];

        /** @var ReflectionProperty $property */
        $property = $properties->first(function ($property) use ($actualPropertyName) {
            return $property->getName() === $actualPropertyName;
        });

        if (!$property) {
            return $response;
        }

        $response['exists'] = true;
        $response['isPublic'] = $property->isPublic();
        $response['isInitialised'] = $property->isInitialized($this);
        $response['value'] = $property->isInitialized($this) ? $property->getValue($this) : null;
        $response['property_name'] = $propertyName;
        $response['actual_property_name'] = $actualPropertyName;

        return $response;
    }
}
