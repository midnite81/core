<?php

declare(strict_types=1);

namespace Midnite81\Core\Services;

use Midnite81\Core\Contracts\Services\CounterInterface;

/**
 * A simple class that keeps track of a count
 */
class Counter implements CounterInterface
{
    protected int $count = 0;

    /**
     * Sets the starting point of the counter
     *
     * @return $this
     */
    public function startingPoint(int $value): static
    {
        $this->count = $value;

        return $this;
    }

    /**
     * Gets the current count
     */
    public function get(): int
    {
        return $this->count;
    }

    /**
     * Alias of get
     */
    public function getCurrent(): int
    {
        return $this->get();
    }

    /**
     * Returns if the current count equals the passed value
     */
    public function equals(int $value): bool
    {
        return $this->count === $value;
    }

    /**
     * Increments count by 1
     *
     * @return $this
     */
    public function next(): static
    {
        return $this->increase(1);
    }

    /**
     * Increments the count by what ever value is specified
     *
     * @return $this
     */
    public function incrementBy(int $value): static
    {
        return $this->increase($value);
    }

    /**
     * Decreases the count by what ever value is specified
     *
     * @return $this
     */
    public function decrementBy(int $value): static
    {
        return $this->decrease($value);
    }

    /**
     * Decreases the count by 1
     *
     * @return $this
     */
    public function previous(): static
    {
        return $this->decrease(1);
    }

    /**
     * Increases the value by the specified value
     *
     * @return $this
     */
    protected function increase(int $value): static
    {
        $this->count = $this->count + $value;

        return $this;
    }

    /**
     * Decreases the value by the specified value
     *
     * @return $this
     */
    protected function decrease(int $value): static
    {
        $this->count = $this->count - $value;

        return $this;
    }
}
