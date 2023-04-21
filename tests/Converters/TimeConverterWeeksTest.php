<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\{weeks};

it('converts from weeks to milliseconds', function () {
    expect(weeks(1)->toMilliseconds())->toBe(604800000);
});

it('converts from weeks to microseconds', function () {
    expect(weeks(1)->toMicroseconds())->toBe(604800000000);
});

it('converts from weeks to minutes', function () {
    expect(weeks(1)->toMinutes())->toBe(10080);
});

it('converts from weeks to hours', function () {
    expect(weeks(1)->toHours())->toBe(168);
});

it('converts from weeks to days', function () {
    expect(weeks(1)->toDays())->toBe(7);
});

it('converts from weeks to weeks', function () {
    expect(weeks(1)->toWeeks())->toBe(1);
});

it('converts from weeks to months', function () {
    expect(weeks(4)->toMonths())->toBe(1);
});

it('converts from weeks to quarters', function () {
    expect(weeks(12)->toQuarters())->toBe(1);
});

it('converts from weeks to years', function () {
    expect(weeks(52)->toYears())->toBe(1);
});
