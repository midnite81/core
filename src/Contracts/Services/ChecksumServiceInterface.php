<?php

declare(strict_types=1);

namespace Midnite81\Core\Contracts\Services;

use Midnite81\Core\Enums\Algorithm;

interface ChecksumServiceInterface
{
    /**
     * Calculate the checksum for the given data using the specified algorithm.
     *
     * @param mixed $data The data to calculate the checksum for. If not a string,
     *                    an attempt will be made to convert it to a string
     * @param Algorithm $algorithm The algorithm to be used (default is Algorithm::Sha256).
     * @return string The calculated checksum.
     */
    public function checksum(mixed $data, Algorithm $algorithm = Algorithm::Sha256): string;

    /**
     * Verify if the provided checksum matches the original checksum for the given data.
     *
     * @param string $providedChecksum The checksum provided for verification.
     * @param string $originalChecksum The original checksum to compare against.
     * @return bool Returns true if the provided checksum matches the original checksum, false otherwise.
     */
    public function verifyChecksum(string $providedChecksum, string $originalChecksum): bool;
}
