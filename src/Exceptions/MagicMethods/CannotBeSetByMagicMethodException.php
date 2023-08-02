<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\MagicMethods;

use Exception;

class CannotBeSetByMagicMethodException extends Exception
{
    public function __construct(string $name)
    {
        $message = "The property {$name} cannot be set via magic method";
        parent::__construct($message);
    }
}
