<?php

declare(strict_types=1);

namespace Midnite81\Core\Contracts\Services;

interface CounterInterface
{
    /**
     * Gets the current count
     */
    public function get(): int;

    /**
     * Alias of get
     */
    public function getCurrent(): int;

    /**
     * Returns if the current count equals the passed value
     */
    public function equals(int $value): bool;

    /**
     * Increments count by 1
     *
     * @return $this
     */
    public function next(): static;

    /**
     * Sets the starting point of the counter
     *
     * @return $this
     */
    public function startingPoint(int $value): static;

    /**
     * Increments the count by what ever value is specified
     *
     * @return $this
     */
    public function incrementBy(int $value): static;

    /**
     * Decreases the count by 1
     *
     * @return $this
     */
    public function previous(): static;

    /**
     * Decreases the count by what ever value is specified
     *
     * @return $this
     */
    public function decrementBy(int $value): static;
}
