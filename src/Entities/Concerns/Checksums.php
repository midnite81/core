<?php

declare(strict_types=1);

namespace Midnite81\Core\Entities\Concerns;

use Midnite81\Core\Enums\Algorithm;
use Midnite81\Core\Exceptions\Entities\PropertyIsRequiredException;

trait Checksums
{
    /**
     * Get the checksum of the data using the specified hashing algorithm.
     *
     * This method calculates the checksum of the data by converting it to a JSON representation
     * and applying the specified hashing algorithm. The default hashing algorithm used is SHA-256.
     *
     * @param Algorithm $algorithm The hashing algorithm to use (optional). Defaults to Algorithm::Sha256.
     * @return string The checksum of the data as a hexadecimal string.
     *
     * @throws PropertyIsRequiredException If required properties for JSON conversion are missing.
     */
    public function checksum(Algorithm $algorithm = Algorithm::Sha256): string
    {
        return hash(enum($algorithm), $this->checksumSourceToString($this->getChecksumSourceData()));
    }

    /**
     * Verify the integrity of the data by comparing the provided checksum with the computed checksum.
     *
     * This method calculates the checksum of the data using the specified hashing algorithm,
     * then compares it with the provided checksum to ensure the data's integrity and detect
     * any potential modifications or corruption.
     *
     * @param string $providedChecksum The checksum value provided for verification (hexadecimal string).
     * @param Algorithm $algorithm The hashing algorithm used to compute the checksum (optional).
     *                             Defaults to Algorithm::Sha256.
     * @return bool True if the provided checksum matches the computed checksum, False otherwise.
     *
     * @throws PropertyIsRequiredException If required properties for JSON conversion are missing.
     */
    public function verifyChecksum(string $providedChecksum, Algorithm $algorithm = Algorithm::Sha256): bool
    {
        $computedChecksum = hash(enum($algorithm), $this->checksumSourceToString($this->getChecksumSourceData()));

        return hash_equals($providedChecksum, $computedChecksum);
    }

    /**
     * Get the data used for computing the checksum as a string representation.
     *
     * @return mixed The string representation of the data.
     *
     * @throws PropertyIsRequiredException If required properties for JSON conversion are missing.
     */
    protected function getChecksumSourceData(): mixed
    {
        return $this->toJson();
    }

    /**
     * Convert a value to its string representation.
     *
     * @param mixed $value The value to convert to a string.
     * @return string The string representation of the value.
     */
    protected function checksumSourceToString(mixed $value): string
    {
        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}
