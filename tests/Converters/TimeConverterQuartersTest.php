<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\quarters;

it('converts from quarters to milliseconds', function () {
    expect(quarters(1)->toMilliseconds())->toBe(7776000000);
});

it('converts from quarters to microseconds', function () {
    expect(quarters(1)->toMicroseconds())->toBe(7776000000000);
});

it('converts from quarters to minutes', function () {
    expect(quarters(1)->toMinutes())->toBe(129600);
});

it('converts from quarters to hours', function () {
    expect(quarters(1)->toHours())->toBe(2184);
});

it('converts from quarters to days', function () {
    expect(quarters(1)->toDays())->toBe(91);
});

it('converts from quarters to weeks', function () {
    expect(quarters(1)->toWeeks())->toBe(13);
});

it('converts from quarters to months', function () {
    expect(quarters(1)->toMonths())->toBe(3);
});

it('converts from quarters to quarters', function () {
    expect(quarters(1)->toQuarters())->toBe(1);
});

it('converts from quarters to years', function () {
    expect(quarters(4)->toYears())->toBe(1);
});
