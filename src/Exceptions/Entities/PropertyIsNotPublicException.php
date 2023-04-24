<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Entities;

class PropertyIsNotPublicException extends \Exception
{
    /**
     * @param mixed|string $offset
     */
    public function __construct(mixed $offset)
    {
        parent::__construct("Property [{$offset}] is not public");
    }
}
