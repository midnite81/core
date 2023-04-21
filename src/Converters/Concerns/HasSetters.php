<?php

declare(strict_types=1);

namespace Midnite81\Core\Converters\Concerns;

trait HasSetters
{
    /**
     * Add microseconds
     *
     * @param float|int $value
     * @return $this
     */
    public function fromMicroseconds(float|int $value): static
    {
        $this->microseconds = $value;
        return $this;
    }

    /**
     * Alias of fromMicroseconds for readability
     * @param float|int $value
     * @return $this
     */
    public function andMicroseconds(float|int $value): static
    {
        return $this->fromMicroseconds($value);
    }

    /**
     * Add milliseconds
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function addMilliseconds(float|int $value): static
    {
        return $this->fromMilliseconds($value);
    }

    /**
     * Add seconds
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andSeconds(float|int $value): static
    {
        return $this->fromSeconds($value);
    }

    /**
     * Add minutes
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andMinutes(float|int $value): static
    {
        return $this->fromMinutes($value);
    }

    /**
     * Add hours
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andHours(float|int $value): static
    {
        return $this->fromHours($value);
    }

    /**
     * Add days
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andDays(float|int $value): static
    {
        return $this->fromDays($value);
    }

    /**
     * Add weeks
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andWeeks(float|int $value): static
    {
        return $this->fromWeeks($value);
    }

    /**
     * Add months
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andMonths(float|int $value): static
    {
        return $this->fromMonths($value);
    }

    /**
     * Add quarters
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andQuarters(float|int $value): static
    {
        return $this->fromQuarters($value);
    }

    /**
     * Add years
     *
     * @param float|int $value
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
     * @param float|int $value
     * @return $this
     */
    public function andYears(float|int $value): static
    {
        return $this->fromYears($value);
    }
}
