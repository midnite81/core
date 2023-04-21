<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\{milliseconds};

it('converts from milliseconds to milliseconds', function () {
    expect(milliseconds(1)->toMilliseconds())->toBe(1);
});

it('converts from milliseconds to microseconds', function () {
    expect(milliseconds(1)->toMicroseconds())->toBe(1000);
});

it('converts from milliseconds to minutes', function () {
    expect(milliseconds(60000)->toMinutes())->toBe(1);
});

it('converts from milliseconds to hours', function () {
    expect(milliseconds(3600000)->toHours())->toBe(1);
});

it('converts from milliseconds to days', function () {
    expect(milliseconds(86400000)->toDays())->toBe(1);
});

it('converts from milliseconds to weeks', function () {
    expect(milliseconds(604800000)->toWeeks())->toBe(1);
});

it('converts from milliseconds to months', function () {
    expect(milliseconds(2628000000)->toMonths())->toBe(1);
});

it('converts from milliseconds to quarters', function () {
    expect(milliseconds(7884000000)->toQuarters())->toBe(1);
});

it('converts from milliseconds to years', function () {
    expect(milliseconds(31536000000)->toYears())->toBe(1);
});
