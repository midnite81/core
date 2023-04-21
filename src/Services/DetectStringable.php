<?php

declare(strict_types=1);

namespace Midnite81\Core\Services;

class DetectStringable
{
    /**
     * Determines whether a value can be converted to a string.
     *
     * A value is considered stringable if it is a scalar value (i.e., a string,
     * integer, float, or boolean), or if it is an object that defines a __toString
     * method.
     *
     * @param mixed $value The value to check for stringability.
     * @return bool Returns true if the value can be converted to a string, false otherwise.
     */
    public static function isStringable(mixed $value): bool
    {
        return is_scalar($value) ||
            (is_object($value) && (method_exists($value, '__toString')));
    }

    /**
     * Determines whether a value cannot be converted to a string.
     *
     * A value is considered not stringable if it is not a scalar value (i.e., a string,
     * integer, float, or boolean), or if it is not an object that defines a __toString
     * method.
     *
     * @param mixed $value The value to check for non-stringability.
     * @return bool Returns true if the value can not be converted to a string, false otherwise.
     */
    public static function isNotStringable(mixed $value): bool
    {
        return !self::isStringable($value);
    }
}
