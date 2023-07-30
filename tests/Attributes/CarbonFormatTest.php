<?php

it('initializes the class and public property is available', function () {
    $sut = new \Midnite81\Core\Attributes\CarbonFormat('d/m/Y');

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\CarbonFormat::class)
        ->and($sut->format)->toBe('d/m/Y');
});
