<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

/**
 * Recursively converts a value to a deep array.
 *
 * @param mixed $value The value to convert.
 * @return mixed The converted value.
 */
function toDeepArray(mixed $value): mixed
{
    if (is_array($value)) {
        return array_map(fn ($item) => toDeepArray($item), $value);
    }

    if ($value instanceof \Illuminate\Support\Collection) {
        return $value->map(fn ($item) => toDeepArray($item))->toArray();
    }

    if ($value instanceof \Illuminate\Contracts\Support\Arrayable) {
        return toDeepArray($value->toArray());
    }

    return $value;
}
