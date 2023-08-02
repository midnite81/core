<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\{months};

it('converts from months to weeks', function () {
    expect(months(1)->toWeeks())->toBe(4);
});

it('converts from months to days', function () {
    expect(months(1)->toDays())->toBe(30);
});
