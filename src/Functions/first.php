<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

function first_value(): mixed
{
    $args = func_get_args();

    foreach ($args as $arg) {
        if (!empty($arg)) {
            return $arg;
        }
    }

    return null;
}
