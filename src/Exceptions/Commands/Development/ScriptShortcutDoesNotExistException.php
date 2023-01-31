<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Commands\Development;

class ScriptShortcutDoesNotExistException extends \Exception
{
    public function __construct(string $scriptKey)
    {
        parent::__construct("The script key [$scriptKey] does not exist in the configuration", 0, null);
    }
}
