<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Entities\BaseEntity;

class NullPropertiesEntity extends BaseEntity
{
    public string $title;

    public ?string $description = null;
}
