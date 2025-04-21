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
    public function toArray(bool $ignoreNulls = false): array
    {
        $array = $this->getInitialisedProperties();

        if ($ignoreNulls) {
            $array = array_filter($array, function ($value) {
                return !is_null($value);
            });
        }

        return json_decode(json_encode($array), true);
    }

    /**
     * Returns a limited array with the keys passed
     *
     *
     * @throws PropertyIsRequiredException
     */
    public function toLimitedArray(array $limitToKeys = [], bool $ignoreNulls = false): array
    {
        $array = $this->toArray($ignoreNulls);

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
     *
     * @throws PropertyIsRequiredException
     */
    public function toExcludedArray(array $excludedKeys = [], bool $ignoreNulls = false): array
    {
        $array = $this->toArray($ignoreNulls);

        if (!empty($excludedKeys)) {
            $filterExcludedKeys = function (array $array, array $excludedKeys) {
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
    public function toJson(bool $ignoreNulls = false): string
    {
        return json_encode($this->toArray($ignoreNulls));
    }

    /**
     * @throws PropertyIsRequiredException
     */
    public function toQueryString(?array $limitToKeys = null, bool $ignoreNulls = false): string
    {
        if (!empty($limitToKeys)) {
            return '?' . http_build_query($this->toLimitedArray($limitToKeys, $ignoreNulls));
        }

        return '?' . http_build_query($this->toArray());
    }
}
