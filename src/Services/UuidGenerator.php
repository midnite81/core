<?php

declare(strict_types=1);

namespace Midnite81\Core\Services;

use Midnite81\Core\Contracts\Services\UuidGeneratorInterface;

class UuidGenerator implements UuidGeneratorInterface
{
    /**
     * Generate a UUID
     *
     * @return string
     */
    public function generate(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid4();
    }
}
