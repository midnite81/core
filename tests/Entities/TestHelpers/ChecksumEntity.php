<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Entities\TestHelpers;

use Midnite81\Core\Entities\BaseEntity;

class ChecksumEntity extends BaseEntity
{
    public int $id;

    public string $name;

    /**
     * {@inheritDoc}
     */
    protected function getChecksumSourceData(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
