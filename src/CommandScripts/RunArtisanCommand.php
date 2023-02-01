<?php

declare(strict_types=1);

namespace Midnite81\Core\CommandScripts;

class RunArtisanCommand
{
    public function __construct(
        public string $commandSignature,
        public array $argumentsAndOptions = []
    ) {
    }
}
