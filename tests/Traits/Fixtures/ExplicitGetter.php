<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Traits\Fixtures;

use Midnite81\Core\Attributes\MagicMethods\Getters\CanAccessViaMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Getters\MagicMethodGetExplicit;
use Midnite81\Core\Traits\Entities\Getters;

#[MagicMethodGetExplicit]
class ExplicitGetter
{
    use Getters;

    #[CanAccessViaMagicMethod]
    protected string $name = 'John';

    protected int $age = 30;

    protected string $location = 'London';
}
