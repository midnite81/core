<?php

declare(strict_types=1);

use Midnite81\Core\Tests\CoreTestCase;

uses(CoreTestCase::class);

it('correctly returns the value of an enum', function () {
    $sut = enum(\Midnite81\Core\Enums\ExpectedType::String);

    expect($sut)->toBe('string');
});

it('throws an exception if a class is passed', function () {
    expect(fn () => enum(new \Midnite81\Core\Tests\Helpers\Fixtures\MyClass))->toThrow(
        RuntimeException::class,
        '$value passed to this function was not an enum',
    );
});

it('throws and error if an enum is not passed but string is', function () {
    $sut = fn () => enum('test string');

    expect($sut)->toThrow(
        RuntimeException::class,
        '$value passed to this function was not an enum'
    );
});

it('throws and error if an enum is not passed but class is', function () {
    $sut = fn () => enum(new \Midnite81\Core\Entities\AttemptEntity);

    expect($sut)->toThrow(
        RuntimeException::class,
        '$value passed to this function was not an enum'
    );
});

it('throws and error if an enum is not backed', function () {
    $sut = fn () => enum(\Midnite81\Core\Tests\Fixtures\UnbackedEnum::Today);

    expect($sut)->toThrow(
        RuntimeException::class,
        'The enum passed to this function is not backed'
    );
});
