<?php

declare(strict_types=1);

namespace Midnite81\Core\Services;

use Midnite81\Core\Contracts\Services\ChecksumServiceInterface;
use Midnite81\Core\Contracts\Services\StringableInterface;
use Midnite81\Core\Enums\Algorithm;

class ChecksumService implements ChecksumServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function checksum(mixed $data, Algorithm $algorithm = Algorithm::Sha256): string
    {
        $stringable = app(StringableInterface::class);

        return hash(enum($algorithm), $stringable->toString($data));
    }

    /**
     * {@inheritDoc}
     */
    public function verifyChecksum(
        string $providedChecksum,
        string $originalChecksum
    ): bool {
        return hash_equals($providedChecksum, $originalChecksum);
    }
}
