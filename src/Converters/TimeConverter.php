<?php

declare(strict_types=1);

namespace Midnite81\Core\Converters;

use Midnite81\Core\Converters\Concerns\HasConversions;
use Midnite81\Core\Converters\Concerns\HasSetters;
use Midnite81\Core\Converters\Concerns\HasStaticSetters;

class TimeConverter
{
    use HasConversions,
        HasSetters,
        HasStaticSetters;

    /**
     * The number of microseconds passed to the TimeConverter class.
     */
    protected float|int $microseconds = 0;

    /**
     * The number of milliseconds passed to the TimeConverter class.
     */
    protected float|int $milliseconds = 0;

    /**
     * The number of seconds passed to the TimeConverter class.
     */
    protected float|int $seconds = 0;

    /**
     * The number of minutes passed to the TimeConverter class.
     */
    protected float|int $minutes = 0;

    /**
     * The number of hours passed to the TimeConverter class.
     */
    protected float|int $hours = 0;

    /**
     * The number of days passed to the TimeConverter class.
     */
    protected float|int $days = 0;

    /**
     * The number of weeks passed to the TimeConverter class.
     */
    protected float|int $weeks = 0;

    /**
     * The number of months passed to the TimeConverter class.
     */
    protected float|int $months = 0;

    /**
     * The number of quarters passed to the TimeConverter class.
     */
    protected float|int $quarters = 0;

    /**
     * The number of years passed to the TimeConverter class.
     */
    protected float|int $years = 0;

    /**
     * Instantiate a new instance
     */
    public static function make(): static
    {
        return new static();
    }
}
