<?php

use Midnite81\Core\Services\Execute;

uses(\Midnite81\Core\Tests\CoreTestCase::class);

it('instantiate via factory method', function () {
    $sut = Execute::make();

    expect($sut)->toBeInstanceOf(Execute::class);
});

it('passes thru', function () {
    $execute = Execute::make();

    $sut = $execute->passthru('echo "Hello"');

    expect($sut)->toBe(0);
});

it('passes through', function () {
    $execute = Execute::make();

    $sut = $execute->passThrough('echo "Hello"');

    expect($sut)->toBe(0);
});

it('should execute', function () {
    $execute = Execute::make();

    $sut = $execute->exec('echo "Hello"');

    expect($sut)->toBe([
        'Hello',
    ]);
});

it('should execute system and return result code', function () {
    $execute = Execute::make();

    $sut = $execute->system('echo "Hello"');

    expect($sut)->toBe(0);
});

it('should escape the argument', function () {
    $argument = 'file with spaces.txt';

    // Create an instance of the Execute class
    $execute = new Execute();

    $escapedArgument = $execute->escape($argument);

    expect($escapedArgument)->toBe("'file with spaces.txt'");
});
