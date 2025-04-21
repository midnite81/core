<?php

declare(strict_types=1);

use Midnite81\Core\Exceptions\General\ClassMustImplementFromException;

it('throws the correct exception with correct message when using non-object class names', function () {
    $class = 'MyClass';
    $inheritFromClass = 'MyBaseClass';

    try {
        throw new ClassMustImplementFromException($class, $inheritFromClass);
    } catch (ClassMustImplementFromException $exception) {
        expect($exception->getMessage())->toBe("{$class} must extend from {$inheritFromClass}");
    }
});

it('throws the correct exception with correct message when using object class names', function () {
    $class = new stdClass;
    $inheritFromClass = new stdClass;

    try {
        throw new ClassMustImplementFromException($class, $inheritFromClass);
    } catch (ClassMustImplementFromException $exception) {
        expect($exception->getMessage())->toBe('stdClass must extend from stdClass');
    }
});

it('throws the correct exception with correct message when using class instances', function () {
    class MyBaseClass {}

    class MyClass {}

    $class = new MyClass;
    $inheritFromClass = new MyBaseClass;

    try {
        throw new ClassMustImplementFromException($class, $inheritFromClass);
    } catch (ClassMustImplementFromException $exception) {
        expect($exception->getMessage())->toBe('MyClass must extend from MyBaseClass');
    }
});
