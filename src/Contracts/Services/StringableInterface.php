<?php

declare(strict_types=1);

namespace Midnite81\Core\Contracts\Services;

interface StringableInterface
{
    /**
     * Convert the given value to a string.
     *
     * @param mixed $value The value to be converted to a string.
     * @return string The converted value as a string.
     */
    public function toString(mixed $value): string;
}
