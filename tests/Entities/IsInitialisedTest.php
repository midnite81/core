<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Entities\TestHelpers\InitialisedPropertiesEntity;

it('returns true if the property is initialised', function () {
    $sut = new InitialisedPropertiesEntity();
    $sut->name = 'Dave';

    expect($sut->isInitialised())
        ->toBeTrue();
});

it('returns false if the property is not initialised', function () {
    $sut = new InitialisedPropertiesEntity();

    expect($sut->isInitialised())
        ->toBeFalse();
});
