<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

use ReflectionEnum;
use ReflectionException;
use RuntimeException;

/**
 * Returns the value of a backed enum case
 * If the $value is not a Backed Enum Case, a runtime error will be thrown
 *
 * Example usage: \Midnite81\Core\Functions\enum(\Midnite81\Core\Enums\ExpectedType::String)
 * Result: string
 *
 * @param mixed $value
 * @return mixed
 */
function enum(mixed $value): mixed
{
    try {
        $reflection = new ReflectionEnum($value);
        if (!$reflection->isEnum()) {
            throw new RuntimeException('$value passed to this function is not an enum', 429);
        }
        if (!$reflection->isBacked()) {
            throw new RuntimeException('The enum passed to this function is not backed');
        }

        return $value->value;
    } catch (ReflectionException $e) {
        throw new RuntimeException('$value passed to this function was not an enum', 429, $e);
    }
}
