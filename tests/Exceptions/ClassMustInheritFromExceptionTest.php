<?php

declare(strict_types=1);

use Midnite81\Core\Exceptions\General\ClassMustInheritFromException;

it('throws the correct exception with correct message when using non-object class names', function () {
    $class = 'MyClass';
    $inheritFromClass = 'MyBaseClass';

    try {
        throw new ClassMustInheritFromException($class, $inheritFromClass);
    } catch (ClassMustInheritFromException $exception) {
        expect($exception->getMessage())->toBe("{$class} must implement from {$inheritFromClass}");
    }
});

it('throws the correct exception with correct message when using object class names', function () {
    $class = new stdClass;
    $inheritFromClass = new stdClass;

    try {
        throw new ClassMustInheritFromException($class, $inheritFromClass);
    } catch (ClassMustInheritFromException $exception) {
        expect($exception->getMessage())->toBe('stdClass must implement from stdClass');
    }
});

it('throws the correct exception with correct message when using class instances', function () {
    class MySecondBaseClass {}

    class MySecondClass extends MySecondBaseClass {}

    $class = new MySecondClass;
    $inheritFromClass = new MySecondBaseClass;

    try {
        throw new ClassMustInheritFromException($class, $inheritFromClass);
    } catch (ClassMustInheritFromException $exception) {
        expect($exception->getMessage())->toBe('MySecondClass must implement from MySecondBaseClass');
    }
});
