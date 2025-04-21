<?php

declare(strict_types=1);

uses(\Midnite81\Core\Traits\Testing\AssertsUuidV4::class);

it('generates a uuid', function () {
    $sut = (new \Midnite81\Core\Services\UuidGenerator)->generate();

    $this->assertUuidV4($sut);
});
