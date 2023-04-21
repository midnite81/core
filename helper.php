<?php

declare(strict_types=1);

use Midnite81\Core\Converters\TimeConverter;

if (!function_exists('uuid')) {
    /**
     * [Aliased] Generates as UUID 4 string
     *
     * Example Usage: uuid()
     * Example Return: 90517cea-8a9e-46c1-8c44-1a3c03611786
     */
    function uuid(): string
    {
        return \Midnite81\Core\Functions\uuid();
    }
}

if (!function_exists('first_value')) {
    /**
     * [Aliased] Returns the first argument which is not null, or an empty string
     *
     * Example: first_value(null, '', 'Dave');
     * Result: Dave
     */
    function first_value(): mixed
    {
        return \Midnite81\Core\Functions\first_value();
    }
}

if (!function_exists('enum')) {
    /**
     * [Aliased] Returns the value of a backed enum case
     * If the $value is not a Backed Enum Case, a runtime error will be thrown
     *
     * Example usage: enum(\Midnite81\Core\Enums\ExpectedType::String)
     * Result: string
     */
    function enum(mixed $value): mixed
    {
        return \Midnite81\Core\Functions\enum($value);
    }
}

if (!function_exists('tempus')) {
    /**
     * Returns a new instance of the TimeConverter
     */
    function tempus(): TimeConverter
    {
        return new TimeConverter();
    }
}
