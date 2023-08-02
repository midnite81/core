<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Enum;

use Closure;
use ReflectionEnum;

trait Arrayable
{
    /**
     * Returns an array of all cases and their value
     *
     * @param Closure|null $callback An optional callback function to modify the keys of the resulting array.
     *                               The callback function should accept a string parameter (the case name) and
     *                               return the desired key for that case.
     * @return array An associative array containing the cases as keys and their corresponding values.
     */
    public static function toArray(Closure $callback = null): array
    {
        $array = [];
        $enum = new ReflectionEnum(static::class);

        foreach ($enum->getCases() as $case) {
            $key = $case->getName();
            if ($callback !== null) {
                $key = $callback($case->getName());
            }
            $array[$key] = $case->getBackingValue();
        }

        return $array;
    }
}
