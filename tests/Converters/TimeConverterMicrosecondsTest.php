<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\microseconds;

it('converts from microseconds to milliseconds', function () {
    expect(microseconds(1)->toMilliseconds(3))->toBe(0.001);
});

it('converts from microseconds to microseconds', function () {
    expect(microseconds(1)->toMicroseconds())->toBe(1);
});

it('converts from microseconds to minutes', function () {
    expect(microseconds(60000000)->toMinutes())->toBe(1);
});

it('converts from microseconds to hours', function () {
    expect(microseconds(3600000000)->toHours())->toBe(1);
});

it('converts from microseconds to days', function () {
    expect(microseconds(86400000000)->toDays())->toBe(1);
});

it('converts from microseconds to weeks', function () {
    expect(microseconds(604800000000)->toWeeks())->toBe(1);
});

it('converts from microseconds to months', function () {
    expect(microseconds(2628000000000)->toMonths())->toBe(1);
});

it('converts from microseconds to quarters', function () {
    expect(microseconds(7884000000000)->toQuarters())->toBe(1);
});

it('converts from microseconds to years', function () {
    expect(microseconds(31536000000000)->toYears())->toBe(1);
});
