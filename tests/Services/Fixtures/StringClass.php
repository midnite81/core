<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Services\Fixtures;

class StringClass
{
    public function __toString(): string
    {
        return 'This is a string return';
    }
}
