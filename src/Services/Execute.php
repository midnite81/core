<?php

declare(strict_types=1);

namespace Midnite81\Core\Services;

use Midnite81\Core\Contracts\Services\ExecuteInterface;

class Execute implements ExecuteInterface
{
    /**
     * {@inheritDoc}
     */
    public static function make(): ExecuteInterface
    {
        return new self();
    }

    /**
     * {@inheritDoc}
     */
    public function passthru(string $command): int
    {
        passthru($command, $responseCode);

        return $responseCode;
    }

    /**
     * {@inheritDoc}
     */
    public function passThrough(string $command): int
    {
        return $this->passthru($command);
    }

    /**
     * {@inheritDoc}
     */
    public function exec(string $command): array
    {
        exec($command, $response);

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function system(string $command): int
    {
        system($command, $resultCode);

        return $resultCode;
    }

    /**
     * {@inheritDoc}
     */
    public function escape(string $argument): string
    {
        return escapeshellarg($argument);
    }
}
