<?php

declare(strict_types=1);

it('works', function () {
    expect(first_value('', 'b', 'c'))->toBe('b');
});

it('returns the second value after first value is empty', function () {
    expect(first_value('', ['b' => 'b'], ['c' => 'c']))->toBe(['b' => 'b']);
});

it('returns second argument from the array', function () {
    expect(first_value_from_array(['', 'b', 'c']))->toBe('b');
});
