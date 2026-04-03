<?php

it('initializes the class', function () {
    $sut = new \Midnite81\Core\Attributes\TrimString;

    expect($sut)
        ->toBeInstanceOf(\Midnite81\Core\Attributes\TrimString::class);
});
