<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Testing;

trait AssertsUuidV4
{
    /**
     * Asserts that the given value is a valid UUIDv4.
     *
     * @param mixed $actual The value to be validated.
     *
     * @return void
     */
    public function assertUuidV4(mixed $actual): void
    {
        if (!is_string($actual)) {
            $this->fail('The given value is not a string.');
        }

        $uuidV4Pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

        $this->assertTrue(preg_match($uuidV4Pattern, $actual) === 1);
    }
}


