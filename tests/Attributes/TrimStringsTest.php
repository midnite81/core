<?php

it('initializes the class', function () {
    $sut = new \Midnite81\Core\Attributes\TrimStrings;

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\TrimStrings::class);
});
