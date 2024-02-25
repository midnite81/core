<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities;

use ArrayAccess;

/**
 * Class BaseEntity
 *
 * Base abstract class for entity objects, providing common functionality.
 */
abstract class BaseEntity implements ArrayAccess
{
    use Concerns\ArrayAccess;
    use Concerns\Checksums;
    use Concerns\Conversions;
    use Concerns\DataParsing;
    use Concerns\Filtering;
    use Concerns\Mapping;
    use Concerns\PropertyHandling;

    /**
     * An array containing the internal representation of property names.
     *
     * This array is used to map the original property names to their internal representation.
     * It is populated during object initialization, based on PropertyName attributes if available.
     *
     * @var array
     *
     * @readonly
     */
    protected readonly array $internalPropertyNames;

    /**
     * BaseEntity constructor.
     *
     * Performs common setup for entities, such as checking for duplicate PropertyName attributes,
     * creating the internal property name array, and triggering the entity-specific processing.
     */
    public function __construct()
    {
        $this->checkForIdenticalPropertyNameAttributeNames();
        $this->createInternalPropertyNameArray();
        $this->process();
    }

    /**
     * Allows for custom processing in the entity during construction.
     *
     * This method can be overridden in child classes to perform custom processing
     * or additional actions when an instance of the entity is being constructed.
     * It is not declared as abstract, as it does not necessarily need to be implemented
     * in each child class. However, child classes may choose to override and provide
     * specific behavior when required.
     *
     * @return void
     */
    public function process(): void
    {
        // Optionally, child classes can implement their own logic here.
    }
}
