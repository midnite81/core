<?php

use Midnite81\Core\Attributes\PropertyName;

it('initializes the class and public property is available', function () {
    $sut = new PropertyName('Public Property Test');

    expect($sut)
        ->toBeInstanceOf(PropertyName::class)
        ->and($sut->name)->toBe('Public Property Test');
});
