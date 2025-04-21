<?php

it('initializes the class', function () {
    $sut = new \Midnite81\Core\Attributes\IgnoreProperty;

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\IgnoreProperty::class);
});
