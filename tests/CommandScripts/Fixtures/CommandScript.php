<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\CommandScripts\Fixtures;

use Midnite81\Core\Commands\Development\FireScriptsCommand;
use Midnite81\Core\CommandScripts\AbstractCommandScript;
use Midnite81\Core\Contracts\Services\ExecuteInterface;

class CommandScript extends AbstractCommandScript
{
    public function handle(FireScriptsCommand $command, ExecuteInterface $execute): int
    {
          return 0;
    }
}
