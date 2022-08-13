<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions;

class DirectionException extends \Exception
{
    public function __construct(string $direction)
    {
        $message = "The direction specified [$direction] is not valid. ASC or DESC should be specified";

        parent::__construct($message);
    }
}
