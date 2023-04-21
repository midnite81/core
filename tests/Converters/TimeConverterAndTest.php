<?php

declare(strict_types=1);

use Midnite81\Core\Converters\TimeConverter as T;

it('can convert more than one unit', function () {
    expect(T::days(1)->andHours(2)->toHours())->toBe(26)
        ->and(T::days(1)->andHours(2)->andMinutes(30)->toSeconds())->toBe(95400)
        ->and(T::weeks(1)->andDays(2)->toDays())->toBe(9);
});
