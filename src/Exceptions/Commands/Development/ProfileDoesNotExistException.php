<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\Commands\Development;

class ProfileDoesNotExistException extends \Exception
{
    public function __construct(string $profileName)
    {
        parent::__construct("The profile [$profileName] does not exist in the configuration", 0, null);
    }
}
