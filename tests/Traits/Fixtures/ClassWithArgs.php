<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Traits\Fixtures;

use Midnite81\Core\Traits\Instantiate;

class ClassWithArgs
{
    use Instantiate;

    public function __construct(protected string $name, protected array $hobbies) {}

    public function greet(): string
    {
        $hobbies = implode(', ', $this->hobbies);

        return "Hi there, {$this->name}! You like the following hobbies: {$hobbies}";
    }
}
