<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Entities\BaseEntity;

class InitialisedPropertiesEntity extends BaseEntity
{
    public string $name;

    public function isInitialised(): bool
    {
        return $this->isPropertyInitialised('name');
    }
}
