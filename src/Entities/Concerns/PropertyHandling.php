<?php
/**
 * PropertyHandling Trait
 *
 * This trait provides methods for handling properties within entities.
 *
 * PHP version 7.0
 *
 * @license MIT License
 */

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

use Carbon\Carbon;
use Midnite81\Core\Attributes\CarbonFormat;
use Midnite81\Core\Attributes\IgnoreProperty;
use Midnite81\Core\Attributes\PropertiesMustBeInitialised;
use Midnite81\Core\Attributes\PropertyName;
use Midnite81\Core\Attributes\RequiredProperty;
use Midnite81\Core\Attributes\TimeZone;
use Midnite81\Core\Exceptions\Entities\DuplicatePropertyNameException;
use Midnite81\Core\Exceptions\Entities\PropertiesMustBeInitialisedException;
use Midnite81\Core\Exceptions\Entities\PropertyIsRequiredException;
use ReflectionClass;
use ReflectionProperty;

trait PropertyHandling
{
    /**
     * Get an array of public properties.
     *
     * @return array Array containing the names of all public properties.
     */
    public function getPublicProperties(): array
    {
        $reflection = $this->getReflection();

        $properties = collect($reflection->getProperties(ReflectionProperty::IS_PUBLIC));

        return $properties->map(fn ($property) => $property->name)->toArray();
    }

    /**
     * Gets an array of initialised public properties.
     *
     * @return array Array containing the initialised public properties with their respective values.
     *
     * @throws PropertyIsRequiredException If a required property is not initialised or empty.
     * @throws PropertiesMustBeInitialisedException If not all properties marked with PropertiesMustBeInitialised are initialised.
     */
    public function getInitialisedProperties(): array
    {
        $this->checkRequiredPropertiesAreFilled();
        $reflection = $this->getReflection();

        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        if (!empty($reflection->getAttributes(PropertiesMustBeInitialised::class))) {
            if (!$this->allPropertiesInitialised()) {
                throw new PropertiesMustBeInitialisedException($this);
            }
        }

        $array = [];

        foreach ($properties as $property) {
            $attr = $property->getAttributes(PropertyName::class);
            $carbonAttr = $property->getAttributes(CarbonFormat::class);
            $timezoneAttr = $property->getAttributes(TimeZone::class);
            $ignore = !empty($property->getAttributes(IgnoreProperty::class));

            if ($property->isInitialized($this) && !$ignore) {
                $propertyValue = $property->getValue($this);
                $propertyKey = !empty($attr) ? $attr[0]->getArguments()[0] : $property->getName();

                if ($propertyValue instanceof Carbon && !empty($carbonAttr)) {
                    if (!empty($timezoneAttr)) {
                        $propertyValue = $propertyValue
                            ->timezone($timezoneAttr[0]->getArguments()[0])
                            ->format($carbonAttr[0]->getArguments()[0]);
                    } else {
                        $propertyValue = $propertyValue->format($carbonAttr[0]->getArguments()[0]);
                    }
                }

                $array[$propertyKey] = $propertyValue;
            }
        }

        return $array;
    }

    /**
     * Checks that all public properties have been initialised.
     *
     * @return bool True if all public properties have been initialised; otherwise, false.
     */
    public function allPropertiesInitialised(): bool
    {
        $reflection = $this->getReflection();

        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $total = count($properties);
        $initialised = 0;

        foreach ($properties as $property) {
            if ($property->isInitialized($this)) {
                $initialised++;
            }
        }

        return $total === $initialised;
    }

    /**
     * Checks that no property name attribute has been duplicated.
     *
     * @throws DuplicatePropertyNameException If there are duplicated PropertyName attributes.
     */
    protected function checkForIdenticalPropertyNameAttributeNames(): void
    {
        $reflection = $this->getReflection();

        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        $names = [];

        foreach ($properties as $property) {
            $attr = $property->getAttributes(PropertyName::class);

            if (!empty($attr)) {
                $value = $attr[0]->getArguments()[0];

                if (in_array($value, $names)) {
                    throw new DuplicatePropertyNameException($value, $this);
                }

                $names[] = $value;
            }
        }
    }

    /**
     * Checks to see if all required properties are initialised and not empty.
     *
     * @throws PropertyIsRequiredException If a required property is not initialised or empty.
     */
    protected function checkRequiredPropertiesAreFilled(): void
    {
        $reflection = $this->getReflection();

        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            if ($property->getAttributes(RequiredProperty::class)) {
                if (!$property->isInitialized($this) || empty($property->getValue($this))) {
                    throw new PropertyIsRequiredException($property->getName());
                }
            }
        }
    }

    /**
     * Get reflection class.
     *
     * @return ReflectionClass ReflectionClass instance representing the current class.
     */
    protected function getReflection(): ReflectionClass
    {
        return new ReflectionClass($this);
    }

    /**
     * Determines if a property has been initialised.
     *
     * @param string $propertyName The name of the property.
     * @return bool True if the property has been initialised; otherwise, false.
     */
    protected function isPropertyInitialised(string $propertyName): bool
    {
        $reflection = $this->getReflection();
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            if ($property->getName() === $propertyName) {
                return $property->isInitialized($this);
            }
        }

        return false;
    }

    /**
     * Creates an internal array of property names, using PropertyName attributes if available.
     *
     * This method reflects on the class and gathers public properties. If a property has a PropertyName attribute,
     * the value specified in the attribute is used as the key in the internal array, instead of the property name.
     * The resulting array maps the original property names to their internal representation.
     *
     * @return void
     */
    protected function createInternalPropertyNameArray(): void
    {
        $class = $this->getReflection();
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);
        $internal = [];

        foreach ($properties as $property) {
            $attribute = $property->getAttributes(PropertyName::class);
            if (!empty($attribute)) {
                $internal[$attribute[0]->getArguments()[0]] = $property->getName();
            } else {
                $internal[$property->getName()] = $property->getName();
            }
        }

        $this->internalPropertyNames = $internal;
    }
}
