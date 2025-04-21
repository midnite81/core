<?php

it('initializes the class', function () {
    $sut = new \Midnite81\Core\Attributes\RequiredProperty;

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\RequiredProperty::class);
});
