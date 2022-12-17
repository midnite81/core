<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Arrays;

use RuntimeException;

class ArrayKeyAlreadyExistsException extends RuntimeException
{
    public function __construct(string $key)
    {
        parent::__construct("The key [{$key}] already exists in the array");
    }
}
