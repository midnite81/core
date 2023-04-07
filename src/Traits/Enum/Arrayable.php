<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Enum;

use Closure;
use ReflectionEnum;

trait Arrayable
{
    /**
     * Returns an array of all cases and their value
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
