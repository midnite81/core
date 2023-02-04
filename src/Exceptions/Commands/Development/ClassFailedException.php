<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Commands\Development;

class ClassFailedException extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct("The script class [$class] failed. Aborting the run.", 0, null);
    }
}
