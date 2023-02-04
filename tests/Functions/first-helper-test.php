<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\first_value;

it('returns the first value', function () {
    expect(first_value('a', 'b', 'c'))->toBe('a');
});

it('returns the second value', function () {
    expect(first_value('', 'b', 'c'))->toBe('b');
});

it('returns the second value after first value is null', function () {
    expect(first_value(null, 'b', 'c'))->toBe('b');
});

it('returns the second value after first value is empty', function () {
    expect(first_value('', ['b' => 'b'], ['c' => 'c']))->toBe(['b' => 'b']);
});

it('returns zero from the second value', function () {
    expect(first_value('', 0, ['c' => 'c']))->toBe(0);
});
