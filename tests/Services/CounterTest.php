<?php

declare(strict_types=1);

use Midnite81\Core\Services\Counter;

it('can return current position', function () {
    $sut = new Counter();

    expect($sut->get())
        ->toBe(0)
        ->and($sut->getCurrent())->toBe(0);
});

it('can return true if count matches', function () {
    $sut = new Counter();
    $sut->startingPoint(5);

    expect($sut->equals(5))->toBeTrue();
});

it("can return false if count doesn't match", function () {
    $sut = new Counter();
    $sut->startingPoint(5);

    expect($sut->equals(20))->toBeFalse();
});

it('can return current position with a starting point', function () {
    $sut = new Counter();
    $sut->startingPoint(12);

    expect($sut->get())
        ->toBe(12)
        ->and($sut->getCurrent())->toBe(12);
});

it('can increment with next', function () {
    $sut = new Counter();
    $sut->startingPoint(1)->next();

    expect($sut->get())
        ->toBe(2)
        ->and($sut->getCurrent())->toBe(2);
});

it('can decrement with previous', function () {
    $sut = new Counter();
    $sut->startingPoint(2)->previous();

    expect($sut->get())
        ->toBe(1)
        ->and($sut->getCurrent())->toBe(1);
});

it('can increment with value', function () {
    $sut = new Counter();
    $sut->startingPoint(12)->incrementBy(4);

    expect($sut->get())
        ->toBe(16)
        ->and($sut->getCurrent())->toBe(16);
});

it('can decrement with value', function () {
    $sut = new Counter();
    $sut->startingPoint(12)->decrementBy(4);

    expect($sut->get())
        ->toBe(8)
        ->and($sut->getCurrent())->toBe(8);
});
