<?php

declare(strict_types=1);

namespace Midnite81\Core\Contracts\Services;

use Midnite81\Core\Services\Execute;

interface ExecuteInterface
{
    /**
     * Factory method
     */
    public static function make(): ExecuteInterface;

    /**
     * Execute an external program and display raw output
     */
    public function passthru(string $command): int;

    /**
     * Alias of passthru
     */
    public function passThrough(string $command): int;

    /**
     * Execute an external program
     */
    public function exec(string $command): array;

    /**
     * Execute an external program and display the output
     */
    public function system(string $command): int;

    /**
     * Escape Shell Argument
     */
    public function escape(string $argument): string;
}
