<?php

declare(strict_types=1);

use Carbon\Carbon;
use Midnite81\Core\Tests\Entities\TestHelpers\CarbonFormattingEntity;

it('can format carbon instances', function () {
    $entity = new CarbonFormattingEntity();
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
