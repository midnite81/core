<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Transformers\Fixtures;

interface TestInterface
{
    public const Red = 'red';

    public const Green = 'green';

    public const Blue = 'blue';

    const Yellow = 'yellow';

    const Allowed = [
        self::Blue,
        self::Green,
    ];
}
