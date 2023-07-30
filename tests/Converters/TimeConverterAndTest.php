<?php

declare(strict_types=1);

use Midnite81\Core\Converters\TimeConverter as T;

it('can convert more than one unit', function () {
    expect(T::days(1)->andHours(2)->toHours())
        ->toBe(26)
        ->and(T::days(1)->andHours(2)->andMinutes(30)->toSeconds())->toBe(95400)
        ->and(T::weeks(1)->andWeeks(2)->andDays(2)->toDays())->toBe(23)
        ->and(T::years(1)->andYears(2)->toYears())->toBe(3)
        ->and(T::quarters(1)->andQuarters(2)->toQuarters())->toBe(3)
        ->and(T::months(1)->andMonths(2)->toMonths())->toBe(3)
        ->and(T::seconds(1)->andSeconds(2)->toSeconds())->toBe(3)
        ->and(T::microseconds(1)->andMicroseconds(2)->toMicroseconds())->toBe(3)
        ->and(T::milliseconds(1)->addMilliseconds(2)->toMilliseconds())->toBe(3);
});
