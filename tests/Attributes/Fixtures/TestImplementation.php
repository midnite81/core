<?php

namespace Midnite81\Core\Tests\Attributes\Fixtures;

class TestImplementation implements TestInterface
{
    public function getName(): string
    {
        return 'Test Implementation';
    }
}
