<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

/**
 * Class Cast
 *
 * @method to(mixed $value, string $cast): float|object|array|bool|int|string|null
 * @method castIfNotEmpty(mixed $value, string $cast): mixed
 * @method nullIfEmpty(string $value): ?string
 */
class Cast
{
    /**
     * Casts the value to the specified type.
     *
     * @param mixed $value
     * @param string $cast The type to cast the value to. The valid options are:
     *                     - 'int' for integer
     *                     - 'string' for string
     *                     - 'bool' for boolean
     *                     - 'float' for float
     *                     - 'array' for array
     *                     - 'object' for object
     * @return float|object|array|bool|int|string|null The value cast to the specified type.
     */
    public static function to(mixed $value, string $cast): float|object|array|bool|int|string|null
    {
        return match ($cast) {
            'int' => (int) $value,
            'string' => (string) $value,
            'bool' => (bool) $value,
            'float' => (float) $value,
            'array' => (array) $value,
            'object' => (object) $value,
            default => $value,
        };
    }

    /**
     * Convert the value to the specified type if it is not empty.
     *
     * @param string $cast The type to which the value should be cast.
     * @return mixed The converted value if it is not empty, otherwise returns the original value.
     */
    public static function castIfNotEmpty(mixed $value, string $cast): mixed
    {
        if (empty($value)) {
            return $value;
        }

        return static::to($value, $cast);
    }

    /**
     * Returns the value if it is not empty, otherwise returns null.
     *
     * @return string|null The trimmed value of the string if it is not empty, otherwise null.
     */
    public static function nullIfEmpty(string $value): ?string
    {
        return trim($value) ?: null;
    }

    /**
     * Provide dynamic access to the class method (non-static).
     *
     * @param string $name The name of the method being called.
     * @param array $arguments Enumerated array containing the parameters passed to the function.
     * @return mixed The result of calling the method.
     */
    public function __call(string $name, array $arguments)
    {
        if (method_exists(self::class, $name)) {
            return self::{$name}(...$arguments);
        }

        throw new \BadMethodCallException("Method {$name} does not exist");
    }
}
