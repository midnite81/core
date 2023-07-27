<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

trait Filtering
{
    /**
     * Filters entity properties based on the provided keys.
     *
     * @param array $entityProperties The array containing the entity properties.
     * @param array $limitToKeys The keys to filter the entity properties by.
     * @return array The filtered entity properties array with only the specified keys.
     */
    protected function filterKeys(array $entityProperties, array $limitToKeys): array
    {
        return array_filter($entityProperties, function ($key) use ($limitToKeys) {
            return in_array($key, $limitToKeys);
        }, ARRAY_FILTER_USE_KEY);
    }
}
