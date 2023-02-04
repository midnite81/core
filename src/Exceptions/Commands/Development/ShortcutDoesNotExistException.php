<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Commands\Development;

class ShortcutDoesNotExistException extends \Exception
{
    public function __construct(string $shortcutKey)
    {
        parent::__construct("The shortcut key [$shortcutKey] does not exist in the configuration", 0, null);
    }
}
