<?php

declare(strict_types=1);

use Midnite81\Core\Converters\TimeConverter;

it('constructs microseconds', function () {
    $sut = TimeConverter::microseconds(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs milliseconds', function () {
    $sut = TimeConverter::milliseconds(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs seconds', function () {
    $sut = TimeConverter::seconds(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs minutes', function () {
    $sut = TimeConverter::minutes(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs hours', function () {
    $sut = TimeConverter::hours(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs days', function () {
    $sut = TimeConverter::days(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs weeks', function () {
    $sut = TimeConverter::weeks(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs months', function () {
    $sut = TimeConverter::months(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs quarters', function () {
    $sut = TimeConverter::quarters(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});

it('constructs years', function () {
    $sut = TimeConverter::years(1);

    expect($sut)->toBeInstanceOf(TimeConverter::class);
});
