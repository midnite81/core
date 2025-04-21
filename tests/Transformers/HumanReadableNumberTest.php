<?php

declare(strict_types=1);

use Midnite81\Core\Exceptions\Transformers\NumberCannotBeNullException;
use Midnite81\Core\Transformers\HumanReadableNumber;

it('transforms numbers correctly', function ($number, $expected) {
    expect((new HumanReadableNumber($number))->humanReadable())->toBe($expected);
})->with('HumanReadableNumbers');

it('transforms numbers correctly when using the factory method', function ($number, $expected) {
    expect(HumanReadableNumber::make($number)->humanReadable())->toBe($expected);
})->with('HumanReadableNumbers');

it('transforms numbers correctly when using the of method', function ($number, $expected) {
    $humanNumber = new HumanReadableNumber;
    expect($humanNumber->of($number)->humanReadable())->toBe($expected);
})->with('HumanReadableNumbers');

it('transforms the number correctly when precision is set', function () {
    expect((new HumanReadableNumber(123456789))->humanReadable(4))->toBe('123.4568M');
});

it('throws an exception when the number is null', function () {
    (new HumanReadableNumber)->humanReadable();
})->throws(NumberCannotBeNullException::class);

it('contains an exception when trying to resolve a human formatted number', function () {
    expect((new HumanReadableNumber)->tryHumanReadable())->toBe('');
});
