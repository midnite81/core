<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

use Midnite81\Core\Exceptions\Entities\PropertyIsRequiredException;

trait Conversions
{
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
     * Returns the initialised properties of the entity as an array, excluding specified keys
     *
     * @param array $excludedKeys The keys to be excluded from the resulting array (optional)
     * @return array The array representation of the entity with excluded keys (if specified)
     * @throws PropertyIsRequiredException
     */
    public function toExcludedArray(array $excludedKeys = []): array
    {
        $array = $this->toArray();

        if (!empty($excludedKeys)) {
            $filterExcludedKeys = function(array $array, array $excludedKeys) {
                foreach ($excludedKeys as $key) {
                    unset($array[$key]);
                }
                return $array;
            };

            return $filterExcludedKeys($array, $excludedKeys);
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
}
