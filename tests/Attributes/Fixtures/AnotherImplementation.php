<?php

namespace Midnite81\Core\Tests\Attributes\Fixtures;

class AnotherImplementation implements TestInterface
{
    public function getName(): string
    {
        return 'Another Implementation';
    }
}
