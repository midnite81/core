<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\years;

it('converts from years to milliseconds', function () {
    expect(years(1)->toMilliseconds())->toBe(31536000000);
});

it('converts from years to microseconds', function () {
    expect(years(1)->toMicroseconds())->toBe(31536000000000);
});

it('converts from years to minutes', function () {
    expect(years(1)->toMinutes())->toBe(525600);
});

it('converts from years to hours', function () {
    expect(years(1)->toHours())->toBe(8760);
});

it('converts from years to days', function () {
    expect(years(1)->toDays())->toBe(365);
});

it('converts from years to weeks', function () {
    expect(years(1)->toWeeks())->toBe(52);
});

it('converts from years to months', function () {
    expect(years(1)->toMonths())->toBe(12);
});

it('converts from years to quarters', function () {
    expect(years(1)->toQuarters())->toBe(4);
});

it('converts from years to years', function () {
    expect(years(1)->toYears())->toBe(1);
});
