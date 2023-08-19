<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Enum;

use Midnite81\Core\Exceptions\Enums\CaseNotFoundException;

trait FindCase
{
    /**
     * Find enum by its value.
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFindByValue(string|int $value): ?static {
        try {
            return static::findByValue($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Find enum by its value.
     *
     * @param mixed $value
     * @return static|null
     * @throws CaseNotFoundException
     */
    public static function findByValue(string|int $value): ?static {
        foreach (static::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        throw new CaseNotFoundException('Case not found');
    }

    /**
     * Tries to find an instance by its name.
     *
     * @param string $name The name of the instance to find.
     *
     * @return static|null The found instance or null if it was not found.
     */
    public function tryFindByName(string $name): ?static
    {
        try {
            return static::findByName($name);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Find enum by its case name in a case-insensitive manner.
     *
     * @param string $name
     * @return static|null
     * @throws CaseNotFoundException
     */
    public static function findByName(string $name): ?static {
        foreach (static::cases() as $case) {
            if (strtolower($case->name) === strtolower($name)) {
                return $case;
            }
        }

        throw new CaseNotFoundException('Case not found');
    }
}

