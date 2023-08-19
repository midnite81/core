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
        $args = func_get_args();

        return \Midnite81\Core\Functions\first_value(...$args);
    }
}

if (!function_exists('first_value_from_array')) {
    /**
     * [Aliased] Retrieve the first non-empty value from an array, or a default value if none found.
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
        return \Midnite81\Core\Functions\first_value_from_array($array);
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

if ( ! function_exists('versioned_asset')) {
    /**
     * [Aliased] Generates an asset URL with a versioned query string
     *
     * Example Usage: versioned_asset('css/style.css')
     * Example Return: /css/style.css?v=1234567890
     *
     * @param string $filePath The relative path to the asset file
     * @return string The URL to the versioned asset file
     */
    function versioned_asset(string $filePath): string
    {
       return \Midnite81\Core\Functions\versioned_asset($filePath);
    }
}
