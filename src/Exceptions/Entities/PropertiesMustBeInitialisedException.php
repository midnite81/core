<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Entities;

use RuntimeException;
use Throwable;

class PropertiesMustBeInitialisedException extends RuntimeException
{
    public function __construct($class = null, $message = '', $code = 0, ?Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'All public properties must be initialised on ' . get_class($class);
        }

        parent::__construct($message, $code, $previous);
    }
}
