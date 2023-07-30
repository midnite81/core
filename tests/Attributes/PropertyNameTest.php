<?php

it('initializes the class and public property is available', function () {
    $sut = new \Midnite81\Core\Attributes\PropertyName('Public Property Test');

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\PropertyName::class)
        ->and($sut->name)->toBe('Public Property Test');
});
