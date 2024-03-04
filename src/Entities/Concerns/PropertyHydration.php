<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

use Carbon\Carbon;
use Midnite81\Core\Exceptions\PropertyMappingException;
use ReflectionClass;

trait PropertyHydration
{
    protected array $typeHandlers = [];

    protected array $propertyHandlers = [];

    /**
     * Defines the type handlers for data conversion.
     *
     * This method sets up an array of type handlers that are used to convert data
     * to specific types. Each type handler is defined as a key-value pair in the
     * $typeHandlers array.
     *
     * @return void
     */
    public function defineTypeHandlers(): void
    {
        $this->typeHandlers = [
            Carbon::class => fn($value) => Carbon::parse('Y-m-d H:i:s', $value),
            ...$this->scalarHandlers(),
        ];
    }

    /**
     * Retrieves the scalar handlers for data conversion.
     *
     * This method returns an array of scalar handlers that are used to convert data
     * values to their corresponding scalar types. Each scalar handler is defined as a
     * key-value pair in the returned array.
     *
     * @return array The array of scalar handlers.
     */
    public function scalarHandlers(): array
    {
        return [
            'string' => fn($value) => (string) $value,
            'int' => fn($value) => (int) $value,
            'float' => fn($value) => (float) $value,
            'bool' => fn($value) => (bool) $value,
        ];
    }

    /**
     * Defines the property handlers for data manipulation.
     *
     * This method sets up an array of property handlers that are used to manipulate
     * data for specific properties. Each property handler is defined as a key-value pair in the
     * $propertyHandlers array.
     *
     * @return void
     */
    public function definePropertyHandlers(): void
    {
        $this->propertyHandlers = [
            // for example
            // 'uuid' => fn($value) => $this->handleUuid($value),
        ];
    }

    /**
     * Maps properties from an array or object to the current object instance.
     *
     * @param array|object $data The data to map properties from. Can be an array or an object.
     *
     * @return void
     * @throws PropertyMappingException
     */
    protected function mapProperties(array|object $data): void
    {
        if (is_object($data)) {
            $data = (array)$data;
        }

        $reflection = new ReflectionClass($this);
        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(\Midnite81\Core\Attributes\SourceName::class);
            $sourceNameAttribute = !empty($attributes) ? $attributes[0]->newInstance() : null;
            $sourceName = $sourceNameAttribute ? $sourceNameAttribute->name : $property->getName();

            // Check if the source name exists in the data, continue to next property if not
            if (!array_key_exists($sourceName, $data)) {
                continue;
            }

            $name = $property->getName();

            // Handle properties with the ArrayOf attribute
            $arrayOfAttributes = $property->getAttributes(\Midnite81\Core\Attributes\ArrayOf::class);
            if (!empty($arrayOfAttributes)) {
                $attributeInstance = $arrayOfAttributes[0]->newInstance();
                $className = $attributeInstance->class;

                if (is_array($data[$sourceName])) {
                    $this->$name = array_map(function ($item) use ($className) {
                        // Assumes the class has a constructor that can accept the data for each item
                        return new $className($item);
                    }, $data[$sourceName]);
                }
                continue; // Proceed to the next property after handling
            }

            // Check for a custom property handler
            if (isset($this->propertyHandlers[$name])) {
                $this->$name = call_user_func($this->propertyHandlers[$name], $data[$sourceName]);
                continue;
            }

            // Handle properties based on their type
            $type = $property->getType();
            if (!$type) {
                // Direct assignment if the property has no type
                $this->$name = $data[$sourceName];
                continue;
            }

            $typeName = $type->getName();
            if (isset($this->typeHandlers[$typeName])) {
                // Use a type handler if defined
                $this->$name = call_user_func($this->typeHandlers[$typeName], $data[$sourceName]);
            } else {
                // Direct assignment as a fallback
                $this->$name = $data[$sourceName];
            }
        }
    }
}
