<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\{days};

it('converts from days to milliseconds', function () {
    expect(days(1)->toMilliseconds())->toBe(86400000);
});

it('converts from days to microseconds', function () {
    expect(days(1)->toMicroseconds())->toBe(86400000000);
});

it('converts from days to minutes', function () {
    expect(days(1)->toMinutes())->toBe(1440);
});

it('converts from days to hours', function () {
    expect(days(1)->toHours())->toBe(24);
});

it('converts from days to days', function () {
    expect(days(1)->toDays())->toBe(1);
});

it('converts from days to weeks', function () {
    expect(days(7)->toWeeks())->toBe(1);
});

it('converts from days to months', function () {
    expect(days(30)->toMonths())->toBe(1);
});

it('converts from days to quarters', function () {
    expect(days(90)->toQuarters())->toBe(1);
});

it('converts from days to years', function () {
    expect(days(365)->toYears())->toBe(1);
});
