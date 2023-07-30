<?php

declare(strict_types=1);

namespace Midnite81\Core\Services;

use Midnite81\Core\Contracts\Services\StringableInterface;
use Midnite81\Core\Traits\Instantiate;

class Stringable implements StringableInterface
{
    use Instantiate;

    /**
     * Convert the given value to a string.
     *
     * @param mixed $value The value to be converted to a string.
     * @return string The converted value as a string.
     */
    public function toString(mixed $value): string
    {
        if (is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}
