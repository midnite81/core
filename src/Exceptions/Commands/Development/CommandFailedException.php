<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Commands\Development;

class CommandFailedException extends \Exception
{
    public function __construct(string $command)
    {
        parent::__construct("The command [$command] failed. Aborting the run.", 0, null);
    }
}
