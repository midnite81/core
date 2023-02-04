<?php

declare(strict_types=1);

namespace Midnite81\Core\Contracts\Services;

use Midnite81\Core\Services\Execute;

interface ExecuteInterface
{
    /**
     * Factory method
     *
     * @return ExecuteInterface
     */
    public static function make(): ExecuteInterface;

    /**
     * Execute an external program and display raw output
     *
     * @param string $command
     * @return int
     */
    public function passthru(string $command): int;

    /**
     * Alias of passthru
     *
     * @param string $command
     * @return int
     */
    public function passThrough(string $command): int;

    /**
     * Execute an external program
     *
     * @param string $command
     * @return array
     */
    public function exec(string $command): array;

    /**
     * Execute an external program and display the output
     *
     * @param string $command
     * @return int
     */
    public function system(string $command): int;

    /**
     * Escape Shell Argument
     *
     * @param string $argument
     * @return string
     */
    public function escape(string $argument): string;
}
