<?php

declare(strict_types=1);

uses(\Midnite81\Core\Traits\Testing\AssertsUuidV4::class);

it('fails if not string passed', function () {
    expect(fn () => $this->assertUuidV4(['array']))
        ->toThrow(Exception::class, 'The given value is not a string');
});
