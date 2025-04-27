<?php

namespace Midnite81\Core\Tests\Attributes\Fixtures;

class InvalidImplementation
{
    public function getSomething(): string
    {
        return 'Invalid Implementation';
    }
}
