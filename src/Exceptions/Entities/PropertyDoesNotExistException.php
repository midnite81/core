<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Entities;

class PropertyDoesNotExistException extends \Exception
{
    public function __construct(mixed $offset)
    {
        parent::__construct('Property [' . $offset . '] does not exist');
    }
}
