<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits;

trait Instantiate
{
    /**
     * Create a new instance of the class using the given arguments.
     *
     * @param mixed ...$args The arguments to pass to the class constructor.
     * @return self A new instance of the class.
     */
    public static function make(...$args): self
    {
        return new static(...$args);
    }

    /**
     * Create a new instance of the class using the given arguments.
     *
     * @param mixed ...$args The arguments to pass to the class constructor.
     * @return self A new instance of the class.
     */
    public static function create(...$args): self
    {
        return new static(...$args);
    }
}
