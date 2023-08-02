<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Traits\Fixtures;

use Midnite81\Core\Attributes\MagicMethods\Getters\AccessPublicPropertiesOnly;
use Midnite81\Core\Traits\Entities\Getters;

#[AccessPublicPropertiesOnly]
class PublicPropsOnly
{
    use Getters;

    public string $name = 'John Doe';

    protected int $age = 30;
}
