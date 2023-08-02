<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\MagicMethods;

use Exception;

class CannotGetByMagicMethodException extends Exception
{
    public function __construct(string $name)
    {
        $message = "The property {$name} cannot be accessed via magic method";
        parent::__construct($message);
    }
}
