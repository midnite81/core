<?php

declare(strict_types=1);

namespace Midnite81\Core\Tests\Exceptions\Fixtures;

use Midnite81\Core\Exceptions\MethodNotImplementedException;

class ExceptionTestingClass
{
    public function handle()
    {
        throw MethodNotImplementedException::forUnimplementedClassMethod($this, 'handle');
    }
}
