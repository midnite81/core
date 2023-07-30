<?php

declare(strict_types=1);

it('can instantiate class with no args', function () {
    $sut = \Midnite81\Core\Tests\Traits\Fixtures\ClassWithoutArgs::make();

    expect($sut)->toBeInstanceOf(\Midnite81\Core\Tests\Traits\Fixtures\ClassWithoutArgs::class)
        ->and($sut->greet())->toBe('Hi there!');

    $sut2 = \Midnite81\Core\Tests\Traits\Fixtures\ClassWithoutArgs::create();

    expect($sut2)->toBeInstanceOf(\Midnite81\Core\Tests\Traits\Fixtures\ClassWithoutArgs::class)
                ->and($sut2->greet())->toBe('Hi there!');
});

it('can instantiate class with args', function () {
    $sut = \Midnite81\Core\Tests\Traits\Fixtures\ClassWithArgs::make('Dave', ['swimming', 'running']);

    expect($sut)->toBeInstanceOf(\Midnite81\Core\Tests\Traits\Fixtures\ClassWithArgs::class)
                ->and($sut->greet())->toBe('Hi there, Dave! You like the following hobbies: swimming, running');

    $sut2 = \Midnite81\Core\Tests\Traits\Fixtures\ClassWithArgs::create('Dave', ['swimming', 'running']);

    expect($sut2)->toBeInstanceOf(\Midnite81\Core\Tests\Traits\Fixtures\ClassWithArgs::class)
                ->and($sut2->greet())->toBe('Hi there, Dave! You like the following hobbies: swimming, running');
});

it('throws an error if no args are passed when it is expecting them', function () {
    expect(fn() => \Midnite81\Core\Tests\Traits\Fixtures\ClassWithArgs::make())
        ->toThrow(ArgumentCountError::class)
        ->and(fn() => \Midnite81\Core\Tests\Traits\Fixtures\ClassWithArgs::create())
        ->toThrow(ArgumentCountError::class);

});
