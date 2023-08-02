<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Traits\Fixtures;

use Midnite81\Core\Attributes\MagicMethods\Setters\CanSetViaMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Setters\MagicMethodSetExplicit;
use Midnite81\Core\Traits\Entities\FluentSetters;

#[MagicMethodSetExplicit]
class ExplicitSetter
{
    use FluentSetters;

    protected string $name;

    #[CanSetViaMagicMethod]
    protected int $age;

    private string $address = 'London';
}
