<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\seconds;

it('converts from seconds to milliseconds', function () {
    expect(seconds(1)->toMilliseconds())->toBe(1000);
});

it('converts from seconds to microseconds', function () {
    expect(seconds(1)->toMicroseconds())->toBe(1000000);
});

it('converts from seconds to minutes', function () {
    expect(seconds(60)->toMinutes())->toBe(1);
});

it('converts from seconds to hours', function () {
    expect(seconds(3600)->toHours())->toBe(1);
});

it('converts from seconds to days', function () {
    expect(seconds(86400)->toDays())->toBe(1);
});

it('converts from seconds to weeks', function () {
    expect(seconds(604800)->toWeeks())->toBe(1);
});

it('converts from seconds to months', function () {
    expect(seconds(2628000)->toMonths())->toBe(1);
});

it('converts from seconds to quarters', function () {
    expect(seconds(7884000)->toQuarters())->toBe(1);
});

it('converts from seconds to years', function () {
    expect(seconds(31536000)->toYears())->toBe(1);
});
