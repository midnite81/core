<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Store;

use Exception;
use Throwable;

class RecordNotFoundException extends Exception
{
    public function __construct(int|string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('Record with id %s was not found', $id);
        parent::__construct($message, $code, $previous);
    }
}
