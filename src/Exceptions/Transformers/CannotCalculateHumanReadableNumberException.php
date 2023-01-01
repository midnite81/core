<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Transformers;

class CannotCalculateHumanReadableNumberException extends \Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?: 'Cannot calculate human readable number');
    }
}
