<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\minutes;

it('converts from minutes to milliseconds', function () {
    expect(minutes(1)->toMilliseconds())->toBe(60000);
});

it('converts from minutes to microseconds', function () {
    expect(minutes(1)->toMicroseconds())->toBe(60000000);
});

it('converts from minutes to minutes', function () {
    expect(minutes(1)->toMinutes())->toBe(1);
});

it('converts from minutes to hours', function () {
    expect(minutes(60)->toHours())->toBe(1);
});

it('converts from minutes to days', function () {
    expect(minutes(1440)->toDays())->toBe(1);
});

it('converts from minutes to weeks', function () {
    expect(minutes(10080)->toWeeks())->toBe(1);
});

it('converts from minutes to months', function () {
    expect(minutes(43800)->toMonths())->toBe(1);
});

it('converts from minutes to quarters', function () {
    expect(minutes(131400)->toQuarters())->toBe(1);
});

it('converts from minutes to years', function () {
    expect(minutes(525600)->toYears())->toBe(1);
});
