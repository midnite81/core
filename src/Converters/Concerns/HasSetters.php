<?php

declare(strict_types=1);

namespace Midnite81\Core\Converters\Concerns;

trait HasSetters
{
    /**
     * Add microseconds
     *
     * @return $this
     */
    public function fromMicroseconds(float|int $value): static
    {
        $this->microseconds = $value;

        return $this;
    }

    /**
     * Alias of fromMicroseconds for readability
     *
     * @return $this
     */
    public function andMicroseconds(float|int $value): static
    {
        return $this->fromMicroseconds($value);
    }

    /**
     * Add milliseconds
     *
     * @return $this
     */
    public function fromMilliseconds(float|int $value): static
    {
        $this->milliseconds = $value;

        return $this;
    }

    /**
     * Alias of fromMilliseconds for readability
     *
     * @return $this
     */
    public function addMilliseconds(float|int $value): static
    {
        return $this->fromMilliseconds($value);
    }

    /**
     * Add seconds
     *
     * @return $this
     */
    public function fromSeconds(float|int $value): static
    {
        $this->seconds = $value;

        return $this;
    }

    /**
     * Alias of fromSeconds for readability
     *
     * @return $this
     */
    public function andSeconds(float|int $value): static
    {
        return $this->fromSeconds($value);
    }

    /**
     * Add minutes
     *
     * @return $this
     */
    public function fromMinutes(float|int $value): static
    {
        $this->minutes = $value;

        return $this;
    }

    /**
     * Alias of fromMinutes for readability
     *
     * @return $this
     */
    public function andMinutes(float|int $value): static
    {
        return $this->fromMinutes($value);
    }

    /**
     * Add hours
     *
     * @return $this
     */
    public function fromHours(float|int $value): static
    {
        $this->hours = $value;

        return $this;
    }

    /**
     * Alias of fromHours for readability
     *
     * @return $this
     */
    public function andHours(float|int $value): static
    {
        return $this->fromHours($value);
    }

    /**
     * Add days
     *
     * @return $this
     */
    public function fromDays(float|int $value): static
    {
        $this->days = $value;

        return $this;
    }

    /**
     * Alias of fromDays for readability
     *
     * @return $this
     */
    public function andDays(float|int $value): static
    {
        return $this->fromDays($value);
    }

    /**
     * Add weeks
     *
     * @return $this
     */
    public function fromWeeks(float|int $value): static
    {
        $this->weeks = $value;

        return $this;
    }

    /**
     * Alias of fromWeeks for readability
     *
     * @return $this
     */
    public function andWeeks(float|int $value): static
    {
        return $this->fromWeeks($value);
    }

    /**
     * Add months
     *
     * @return $this
     */
    public function fromMonths(float|int $value): static
    {
        $this->months = $value;

        return $this;
    }

    /**
     * Alias of fromMonths for readability
     *
     * @return $this
     */
    public function andMonths(float|int $value): static
    {
        return $this->fromMonths($value);
    }

    /**
     * Add quarters
     *
     * @return $this
     */
    public function fromQuarters(float|int $value): static
    {
        $this->quarters = $value;

        return $this;
    }

    /**
     * Alias of fromQuarters for readability
     *
     * @return $this
     */
    public function andQuarters(float|int $value): static
    {
        return $this->fromQuarters($value);
    }

    /**
     * Add years
     *
     * @return $this
     */
    public function fromYears(float|int $value): static
    {
        $this->years = $value;

        return $this;
    }

    /**
     * Alias of fromYears for readability
     *
     * @return $this
     */
    public function andYears(float|int $value): static
    {
        return $this->fromYears($value);
    }
}
