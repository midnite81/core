<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Transformers;

class NumberCannotBeNullException extends \Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?: 'The number passed cannot be null');
    }
}
