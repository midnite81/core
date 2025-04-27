<?php

namespace Midnite81\Core\Tests\Attributes\Fixtures;

class MockContainer
{
    private array $instances = [];

    public function register(string $abstract, object $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    public function make(string $abstract)
    {
        return $this->instances[$abstract] ?? new $abstract();
    }
}
