<?php

it('initializes the class and public property is available', function () {
    $sut = new \Midnite81\Core\Attributes\TimeZone('Europe/London');

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\TimeZone::class)
        ->and($sut->timezone)->toBe('Europe/London');
});
