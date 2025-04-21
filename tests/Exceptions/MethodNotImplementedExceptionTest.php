<?php

declare(strict_types=1);

use Midnite81\Core\Tests\Exceptions\Fixtures\ExceptionTestingClass;

it('throws an class/method exception', function () {
    $testClass = new ExceptionTestingClass;

    expect(fn () => $testClass->handle())
        ->toThrow(
            \Midnite81\Core\Exceptions\MethodNotImplementedException::class,
            'Method handle has not been implemented on class Midnite81\Core\Tests\Exceptions\Fixtures\ExceptionTestingClass'
        );
});

it('throws an function exception', function () {
    $testClass = new ExceptionTestingClass;

    expect(fn () => throw \Midnite81\Core\Exceptions\MethodNotImplementedException::forUnimplementedFunction('timer'))
        ->toThrow(
            \Midnite81\Core\Exceptions\MethodNotImplementedException::class,
            'Function timer has not been implemented'
        );
});
