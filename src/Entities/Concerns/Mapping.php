<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

use Closure;
use Illuminate\Support\Collection;
use Midnite81\Core\Entities\BaseEntity;

trait Mapping
{
    /**
     * Maps data to the entity.
     *
     * @param array $data The data to map to the entity.
     * @return BaseEntity|Mapping The current instance of the entity with mapped data.
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

    /**
     * Loops over the data array and calls the callback on each item
     * and returns it to the original array.
     *
     * @param array $originalArray The original array to which mapped items will be added.
     * @param array $data The data to be mapped to the original array.
     * @param Closure $callback The callback function to be applied to each item.
     */
    public function mapArray(array &$originalArray, array $data, Closure $callback): void
    {
        foreach ($data as $item) {
            $originalArray[] = $callback($item);
        }
    }

    /**
     * Loops over the data array and calls the callback on each item
     * and returns it to the original collection.
     *
     * @param Collection $collection The original collection to which mapped items will be added.
     * @param array $data The data to be mapped to the original collection.
     * @param Closure $callback The callback function to be applied to each item.
     */
    public function mapCollection(Collection $collection, array $data, Closure $callback): void
    {
        foreach ($data as $item) {
            $collection->push($callback($item));
        }
    }
}
