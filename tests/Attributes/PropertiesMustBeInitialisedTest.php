<?php

it('initializes the class', function () {
    $sut = new \Midnite81\Core\Attributes\PropertiesMustBeInitialised();

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\PropertiesMustBeInitialised::class);
});
