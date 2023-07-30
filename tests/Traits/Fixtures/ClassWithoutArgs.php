<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Traits\Fixtures;

use Midnite81\Core\Traits\Instantiate;

class ClassWithoutArgs
{
    use Instantiate;

    public function greet(): string
    {
        return 'Hi there!';
    }
}
