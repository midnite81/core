<?php

declare(strict_types=1);

use Carbon\Carbon;
use Midnite81\Core\Tests\Entities\TestHelpers\CarbonFormattingEntity;

it('can format carbon instances', function () {
    $entity = new CarbonFormattingEntity;
    $entity->dateOfBirth = Carbon::create(1970, 1, 1);
    $entity->someOtherDate = Carbon::create(1963, 12, 10);

    $sut = $entity->toArray();

    expect($sut)
        ->toHaveCount(2)
        ->toHaveKey('dateOfBirth')
        ->toHaveKey('someOtherDate')
        ->and($sut['dateOfBirth'])->toBe('01/01/1970')
        ->and($sut['someOtherDate'])->toBe('10 Dec 1963');
});

it('can provide time in the nominated timezone', function () {
    $entity = new CarbonFormattingEntity;
    $entity->timezoneDateTime = Carbon::create(2020, 1, 1, 12, 0, 0, '-7');

    expect($entity->toArray()['timezoneDateTime'])->toBe('01/01/2020 19:00:00');
});
