<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities;

use Closure;
use Illuminate\Support\Collection;
use Midnite81\Core\Attributes\IgnoreProperty;
use Midnite81\Core\Attributes\PropertiesMustBeInitialised;
use Midnite81\Core\Attributes\PropertyName;
use Midnite81\Core\Attributes\RequiredProperty;
use Midnite81\Core\Exceptions\Entities\DuplicatePropertyNameException;
use Midnite81\Core\Exceptions\Entities\PropertiesMustBeInitialisedException;
use Midnite81\Core\Exceptions\Entities\PropertyIsRequiredException;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseEntity
{
    public function __construct()
    {
        $this->checkForIdenticalPropertyNameAttributeNames();
        $this->process();
    }

    /**
     * Allows for processing in the entity on construction
     * This method should be overridden in child classes.
     * It is not abstract because it does not necessarily need to be
     * implemented in each child class.
     *
     * @return void
     */
    public function process(): void
    {
    }

    /**
     * Returns the initialised properties of the entity as an array
     *
     * @return array<string, mixed>
     *
     * @throws PropertyIsRequiredException
     */
    public function toArray(): array
    {
        return json_decode(json_encode($this->getInitialisedProperties()), true);
    }

    /**
     * Returns a limited array with the keys passed
     *
     * @param  array  $limitToKeys
     * @return array
     *
     * @throws PropertyIsRequiredException
     */
    public function toLimitedArray(array $limitToKeys = []): array
    {
        $array = $this->toArray();

        if (!empty($limitToKeys)) {
            return $this->filterKeys($array, $limitToKeys);
        }

        return $array;
    }

    /**
     * Returns the initialised properties of the entity as a Json String
     *
     * @return string
     *
     * @throws PropertyIsRequiredException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @return string
     *
     * @throws PropertyIsRequiredException
     */
    public function toQueryString(): string
    {
        return '?' . http_build_query($this->toArray());
    }

    /**
     * Maps data to the entity
     *
     * @param  array  $data
     * @return $this
     */
    public function map(array $data = []): self
    {
        $properties = $this->getPublicProperties();

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    public function getPublicProperties(): array
    {
        $reflection = $this->getReflection();

        $properties = collect($reflection->getProperties(ReflectionProperty::IS_PUBLIC));

        return $properties->map(fn ($property) => $property->name)->toArray();
    }

    /**
     * Gets an array of initialised public properties
     *
     * @return array<string, mixed>
     *
     * @throws PropertyIsRequiredException
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
            $ignore = !empty($property->getAttributes(IgnoreProperty::class));

            if ($property->isInitialized($this) && !$ignore) {
                if (!empty($attr)) {
                    $array[$attr[0]->getArguments()[0]] = $property->getValue($this);

                    continue;
                }
                $array[$property->getName()] = $property->getValue($this);
            }
        }

        return $array;
    }

    /**
     * Checks that all public properties have been initialised
     *
     * @return bool
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
     * Checks that no property name attribute has been duplicated
     *
     * @throws DuplicatePropertyNameException
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
     * Loops over the data array and calls the callback on each item
     * and returns it to the original array
     *
     * @param  array  $originalArray
     * @param  array  $data
     * @param  Closure  $callback
     * @return void
     */
    public function mapArray(array &$originalArray, array $data, Closure $callback): void
    {
        foreach ($data as $item) {
            $originalArray[] = $callback($item);
        }
    }

    /**
     * Loops over the data array and calls the callback on each item
     * and returns it to the original collection
     *
     * @param  Collection  $collection
     * @param  array  $data
     * @param  Closure  $callback
     * @return void
     */
    public function mapCollection(Collection $collection, array $data, Closure $callback): void
    {
        foreach ($data as $item) {
            $collection->push($callback($item));
        }
    }

    /**
     * Returns entity properties which have a key which is passed in $limitToKeys
     *
     * @param  array  $entityProperties
     * @param  array  $limitToKeys
     * @return array
     */
    protected function filterKeys(array $entityProperties, array $limitToKeys): array
    {
        return array_filter($entityProperties, function ($key) use ($limitToKeys) {
            return in_array($key, $limitToKeys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Checks to see if all required properties are initialised and not empty
     *
     * @return void
     *
     * @throws PropertyIsRequiredException
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
     * Get reflection class
     *
     * @return ReflectionClass
     */
    protected function getReflection(): ReflectionClass
    {
        return new ReflectionClass($this);
    }

    /**
     * Determines if a property has been initialised
     *
     * @param  string  $propertyName
     * @return bool
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
}
