<?php

declare(strict_types=1);

namespace Midnite81\Core\CommandScripts;

use Midnite81\Core\Commands\Development\FireScriptsCommand;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Exceptions\Commands\Development\CommandFailedException;

abstract class AbstractCommandScript
{
    /**
     * Handles the custom script
     *
     * @param FireScriptsCommand $command
     * @param ExecuteInterface $execute
     * @return int
     *
     * @throws CommandFailedException
     */
    abstract public function handle(FireScriptsCommand $command, ExecuteInterface $execute): int;
}
