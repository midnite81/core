<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Attributes\PropertiesMustBeInitialised;
use Midnite81\Core\Attributes\PropertyName;
use Midnite81\Core\Entities\BaseEntity;

#[PropertiesMustBeInitialised]
class TestIdenticalPropertiesEntity extends BaseEntity
{
    #[PropertyName('identical')]
    public string $title;

    #[PropertyName('identical')]
    public string $description;
}
