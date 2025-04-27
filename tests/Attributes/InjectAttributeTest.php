<?php

declare(strict_types=1);

use Midnite81\Core\Attributes\Contextual\Inject;
use Midnite81\Core\Tests\Attributes\Fixtures\AnotherImplementation;
use Midnite81\Core\Tests\Attributes\Fixtures\InvalidImplementation;
use Midnite81\Core\Tests\Attributes\Fixtures\MockContainer;
use Midnite81\Core\Tests\Attributes\Fixtures\TestImplementation;
use Midnite81\Core\Tests\Attributes\Fixtures\TestInterface;

it('can create an inject attribute instance', function () {
    $inject = new Inject(TestImplementation::class);

    expect($inject)->toBeInstanceOf(Inject::class)
        ->and($inject->implementation)->toBe(TestImplementation::class);
});

it('can resolve an implementation from a container', function () {
    $inject = new Inject(TestImplementation::class);
    $container = new MockContainer();

    // Register an instance in the container
    $testInstance = new TestImplementation();
    $container->register(TestImplementation::class, $testInstance);

    $result = Inject::resolve($inject, $container);

    expect($result)->toBe($testInstance);
});

it('can instantiate a class if not registered in container', function () {
    $inject = new Inject(TestImplementation::class);
    $container = new MockContainer();

    $result = Inject::resolve($inject, $container);

    expect($result)->toBeInstanceOf(TestImplementation::class);
});

it('validates that implementation implements the parameter interface', function () {
    $inject = new Inject(TestImplementation::class);
    $container = new MockContainer();

    $reflectionParameter = new ReflectionParameter(function (TestInterface $param) {}, 'param');

    $result = Inject::resolve($inject, $container, $reflectionParameter);

    expect($result)->toBeInstanceOf(TestImplementation::class);
});

it('allows different implementations of the same interface', function () {
    $inject = new Inject(AnotherImplementation::class);
    $container = new MockContainer();

    $reflectionParameter = new ReflectionParameter(function (TestInterface $param) {}, 'param');

    $result = Inject::resolve($inject, $container, $reflectionParameter);

    expect($result)->toBeInstanceOf(AnotherImplementation::class);
});

it('throws exception when implementation does not implement required interface', function () {
    $inject = new Inject(InvalidImplementation::class);
    $container = new MockContainer();

    $reflectionParameter = new ReflectionParameter(function (TestInterface $param) {}, 'param');

    Inject::resolve($inject, $container, $reflectionParameter);
})->throws(InvalidArgumentException::class,
    "The implementation class [Midnite81\Core\Tests\Attributes\Fixtures\InvalidImplementation] must implement [Midnite81\Core\Tests\Attributes\Fixtures\TestInterface].");

it('skips validation when parameter has no type', function () {
    $inject = new Inject(InvalidImplementation::class);
    $container = new MockContainer();

    $reflectionParameter = new ReflectionParameter(function ($param) {}, 'param');

    $result = Inject::resolve($inject, $container, $reflectionParameter);

    expect($result)->toBeInstanceOf(InvalidImplementation::class);
});

it('skips validation when parameter type is not an interface', function () {
    $inject = new Inject(TestImplementation::class);
    $container = new MockContainer();

    $reflectionParameter = new ReflectionParameter(function (string $param) {}, 'param');

    $result = Inject::resolve($inject, $container, $reflectionParameter);

    expect($result)->toBeInstanceOf(TestImplementation::class);
});

it('works when parameter is null', function () {
    $inject = new Inject(TestImplementation::class);
    $container = new MockContainer();

    $result = Inject::resolve($inject, $container, null);

    expect($result)->toBeInstanceOf(TestImplementation::class);
});

