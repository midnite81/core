<?php

declare(strict_types=1);

namespace Midnite81\Core\Contracts\Services;

interface UuidGeneratorInterface
{
    /**
     * Generate a UUID
     */
    public function generate(): string;
}
