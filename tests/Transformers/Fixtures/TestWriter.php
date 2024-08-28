<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Transformers\Fixtures;

use Midnite81\Core\Transformers\Contracts\WriterInterface;

class TestWriter implements WriterInterface
{
    public function write(array $details): string
    {
        return 'This is a test';
    }
}
