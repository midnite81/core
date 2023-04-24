<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities;

use ArrayAccess;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Midnite81\Core\Attributes\CarbonFormat;
use Midnite81\Core\Attributes\IgnoreProperty;
use Midnite81\Core\Attributes\PropertiesMustBeInitialised;
use Midnite81\Core\Attributes\PropertyName;
use Midnite81\Core\Attributes\RequiredProperty;
use Midnite81\Core\Enums\ExpectedType;
use Midnite81\Core\Exceptions\Entities\DuplicatePropertyNameException;
use Midnite81\Core\Exceptions\Entities\PropertiesMustBeInitialisedException;
use Midnite81\Core\Exceptions\Entities\PropertyDoesNotExistException;
use Midnite81\Core\Exceptions\Entities\PropertyIsNotInitialisedException;
use Midnite81\Core\Exceptions\Entities\PropertyIsNotPublicException;
use Midnite81\Core\Exceptions\Entities\PropertyIsRequiredException;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseEntity implements ArrayAccess
{
    protected readonly array $internalPropertyNames;

    public function __construct()
    {
        $this->checkForIdenticalPropertyNameAttributeNames();
        $this->createInternalPropertyNameArray();
        $this->process();
    }

    /**
     * Allows for processing in the entity on construction
     * This method should be overridden in child classes.
     * It is not abstract because it does not necessarily need to be
     * implemented in each child class.
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
     *
     * @throws PropertyIsRequiredException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @throws PropertyIsRequiredException
     */
    public function toQueryString(?array $limitToKeys = null): string
    {
        if (!empty($limitToKeys)) {
            return '?' . http_build_query($this->toLimitedArray($limitToKeys));
        }

        return '?' . http_build_query($this->toArray());
    }

    /**
     * Maps data to the entity
     *
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
            $carbonAttr = $property->getAttributes(CarbonFormat::class);
            $ignore = !empty($property->getAttributes(IgnoreProperty::class));

            if ($property->isInitialized($this) && !$ignore) {
                $propertyValue = $property->getValue($this);
                $propertyKey = !empty($attr) ? $attr[0]->getArguments()[0] : $property->getName();

                if ($propertyValue instanceof Carbon && !empty($carbonAttr)) {
                    $propertyValue = $propertyValue->format($carbonAttr[0]->getArguments()[0]);
                }

                $array[$propertyKey] = $propertyValue;
            }
        }

        return $array;
    }

    /**
     * Checks that all public properties have been initialised
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
     * Parses data and returns the expected type
     */
    protected function parseData(
        object|array|string $data,
        ExpectedType $expectedResponse = ExpectedType::Object
    ): object|array|string {
        if ((is_string($data) && $expectedResponse === ExpectedType::String) ||
            (is_array($data) && $expectedResponse === ExpectedType::Array) ||
            (is_object($data) && $expectedResponse === ExpectedType::Object)
        ) {
            return $data;
        }

        if (is_string($data) && in_array($expectedResponse, [ExpectedType::Object, ExpectedType::Array])) {
            $assocArray = $expectedResponse === ExpectedType::Array;

            return json_decode($data, $assocArray);
        }

        if (is_array($data) && $expectedResponse === ExpectedType::Object) {
            return json_decode(json_encode($data));
        }

        if (is_object($data) && $expectedResponse === ExpectedType::Array) {
            return (array) $data;
        }

        return $data;
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
     */
    public function mapCollection(Collection $collection, array $data, Closure $callback): void
    {
        foreach ($data as $item) {
            $collection->push($callback($item));
        }
    }

    /**
     * Returns entity properties which have a key which is passed in $limitToKeys
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
     */
    protected function getReflection(): ReflectionClass
    {
        return new ReflectionClass($this);
    }

    /**
     * Determines if a property has been initialised
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
     * Gets property information
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

    /**
     * Creates an internal array of property names, and if they have a PropertyName attribute to get that value as the
     * key instead of the property name
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
