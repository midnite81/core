<?php

declare(strict_types=1);

namespace Midnite81\Core\Converters\Concerns;

trait HasStaticSetters
{
    /**
     * Add microseconds
     *
     * @return $this
     */
    public static function microseconds(float $value): static
    {
        return static::make()->fromMicroseconds($value);
    }

    /**
     * Add milliseconds
     *
     * @return $this
     */
    public static function milliseconds(float $value): static
    {
        return static::make()->fromMilliseconds($value);
    }

    /**
     * Add seconds
     *
     * @return $this
     */
    public static function seconds(float $value): static
    {
        return static::make()->fromSeconds($value);
    }

    /**
     * Add minutes
     *
     * @return $this
     */
    public static function minutes(float $value): static
    {
        return static::make()->fromMinutes($value);
    }

    /**
     * Add hours
     *
     * @return $this
     */
    public static function hours(float $value): static
    {
        return static::make()->fromHours($value);
    }

    /**
     * Add days
     *
     * @return $this
     */
    public static function days(float $value): static
    {
        return static::make()->fromDays($value);
    }

    /**
     * Add weeks
     *
     * @return $this
     */
    public static function weeks(float $value): static
    {
        return static::make()->fromWeeks($value);
    }

    /**
     * Add months
     *
     * @return $this
     */
    public static function months(float $value): static
    {
        return static::make()->fromMonths($value);
    }

    /**
     * Add quarters
     *
     * @return $this
     */
    public static function quarters(float $value): static
    {
        return static::make()->fromQuarter($value);
    }

    /**
     * Add years
     *
     * @return $this
     */
    public static function years(float $value): static
    {
        return static::make()->fromYears($value);
    }
}
