<?php

declare(strict_types=1);

use function Midnite81\Core\Functions\first_value;
use function Midnite81\Core\Functions\first_value_from_array;

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

it('returns second item from an array after the first is null', function () {
    expect(first_value_from_array([null, 'b', 'c']))->toBe('b');
});

it('returns first item from the array as it\'s not null', function () {
    expect(first_value_from_array(['a', 'b', 'c']))->toBe('a');
});
