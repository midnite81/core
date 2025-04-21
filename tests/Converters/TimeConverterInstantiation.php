<?php

declare(strict_types=1);

use Midnite81\Core\Converters\TimeConverter as T;

it('instantiates', function () {
    $sut = new T;

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via factory method', function () {
    $sut = T::make();

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via microseconds', function () {
    $sut = T::microseconds(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via milliseconds', function () {
    $sut = T::milliseconds(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via seconds', function () {
    $sut = T::seconds(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via minutes', function () {
    $sut = T::minutes(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via hours', function () {
    $sut = T::hours(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via days', function () {
    $sut = T::days(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via weeks', function () {
    $sut = T::weeks(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via months', function () {
    $sut = T::months(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via quarters', function () {
    $sut = T::quarters(1);

    expect($sut)->toBeInstanceOf(T::class);
});

it('instantiates via years', function () {
    $sut = T::years(1);

    expect($sut)->toBeInstanceOf(T::class);
});
