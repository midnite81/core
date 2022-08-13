<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Entities;

use RuntimeException;
use Throwable;

class DuplicatePropertyNameException extends RuntimeException
{
    public function __construct(string $value, $class = null, $code = 0, Throwable $previous = null)
    {
        $class = get_class($class);
        $message = "The name [$value] was registered more than once on class [$class]";
        parent::__construct($message, $code, $previous);
    }
}
