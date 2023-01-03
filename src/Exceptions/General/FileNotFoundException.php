<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\General;

class FileNotFoundException extends \Exception
{
    public function __construct(string $message = 'File not found')
    {
        parent::__construct($message);
    }
}
