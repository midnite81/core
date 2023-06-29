<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

/**
 * Returns the first argument which is not null, or an empty string
 *
 * Example: \Midnite81\Core\Functions\first_value(null, '', 'Dave');
 * Result: Dave
 */
function first_value(): mixed
{
    $args = func_get_args();

    foreach ($args as $arg) {
        if (is_string($arg)) {
            $arg = trim($arg);
        }

        if ($arg !== null && $arg !== '') {
            return $arg;
        }
    }

    return null;
}

/**
 * Retrieve the first non-empty value from an array, or a default value if none found.
 *
 * Example: \Midnite81\Core\Functions\first_value_from_array(['', null, 'Dave']);
 * Result: Dave
 *
 * @param array $array The input array to search for values.
 * @param mixed $default The default value to return if no non-empty value is found (default: null).
 * @return mixed The first non-empty value from the array, or the default value if none found.
 */
function first_value_from_array(array $array, mixed $default = null): mixed
{
    foreach ($array as $arg) {
        if (is_string($arg)) {
            $arg = trim($arg);
        }

        if ($arg !== null && $arg !== '') {
            return $arg;
        }
    }

    return $default;
}
