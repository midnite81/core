<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\{hours};

it('converts from hours to days', function () {
    expect(hours(24)->toDays())->toBe(1);
});

it('converts from hours to minutes', function () {
    expect(hours(1)->toMinutes())->toBe(60);
});
