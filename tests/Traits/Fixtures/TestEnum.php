<?php

namespace Midnite81\Core\Tests\Traits\Fixtures;

use Midnite81\Core\Traits\Enum\Arrayable;

enum TestEnum: string
{
    use Arrayable;

    case ONE = 'Value 1';
    case TWO = 'Value 2';
    case THREE = 'Value 3';
}
