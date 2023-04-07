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
