<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Traits\Fixtures;

use Midnite81\Core\Attributes\MagicMethods\Getters\AccessPublicPropertiesOnly;
use Midnite81\Core\Attributes\MagicMethods\Getters\CanAccessViaMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Getters\MagicMethodGetExplicit;
use Midnite81\Core\Traits\Entities\Getters;

#[AccessPublicPropertiesOnly]
#[MagicMethodGetExplicit]
class PublicAndExplicitPropsOnly
{
    use Getters;

    public string $fullName = 'John Doe';

    #[CanAccessViaMagicMethod]
    protected string $name = 'John';
}
