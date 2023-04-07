<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Entities;

use Exception;

class PropertyIsRequiredException extends Exception
{
    public function __construct(string $propertyName)
    {
        $message = sprintf('The property [%s] is required', $propertyName);
        parent::__construct($message);
    }
}
