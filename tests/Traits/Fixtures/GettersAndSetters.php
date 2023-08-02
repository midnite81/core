<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Traits\Fixtures;

class GettersAndSetters
{
    use \Midnite81\Core\Traits\Entities\GettersAndSetters;

    protected string $name = 'Ben';

    protected int $age = 30;
}
