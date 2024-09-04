<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Midnite81\Core\Tests\CoreTestCase;
use Midnite81\Core\Validation\ValidationExceptionBuilder;

uses(CoreTestCase::class, WithoutMiddleware::class);

beforeEach(function () {
    URL::shouldReceive('previous')->andReturn('http://example.com/previous');
});

test('it creates a new instance with a message', function () {
    $builder = ValidationExceptionBuilder::message('Test message');
    expect($builder)->toBeInstanceOf(ValidationExceptionBuilder::class);
});

test('it sets redirect URL', function () {
    $builder = ValidationExceptionBuilder::message('Test')
        ->redirectTo('http://example.com/redirect');

    $exception = null;
    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        $exception = $e;
    }

    expect($exception->redirectTo)->toBe('http://example.com/redirect');
});

test('it redirects back to previous URL', function () {
    $builder = ValidationExceptionBuilder::message('Test')->redirectBack();

    $exception = null;
    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        $exception = $e;
    }

    expect($exception->redirectTo)->toBe('http://example.com/previous');
});

test('it sets redirect route', function () {
    Route::shouldReceive('urlTo')
        ->with('test.route', ['id' => 1])
        ->andReturn('http://example.com/test/1');

    $builder = ValidationExceptionBuilder::message('Test')
        ->redirectRoute('test.route', ['id' => 1]);

    $exception = null;
    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        $exception = $e;
    }

    expect($exception->redirectTo)->toBe('http://example.com/test/1');
});

test('it adds fragment to redirect URL', function () {
    $builder = ValidationExceptionBuilder::message('Test')
        ->redirectTo('http://example.com/redirect')
        ->fragment('section1');

    $exception = null;
    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        $exception = $e;
    }

    expect($exception->redirectTo)->toBe('http://example.com/redirect#section1');
});

test('it adds query parameters to redirect URL', function () {
    $builder = ValidationExceptionBuilder::message('Test')
        ->redirectTo('http://example.com/redirect')
        ->withQueryParameters(['param1' => 'value1', 'param2' => 'value2']);

    $exception = null;
    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        $exception = $e;
    }

    expect($exception->redirectTo)->toBe('http://example.com/redirect?param1=value1&param2=value2');
});

test('it sets error bag', function () {
    $builder = ValidationExceptionBuilder::message('Test')
        ->errorBag('custom_error_bag');

    $exception = null;
    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        $exception = $e;
    }

    expect($exception->errorBag)->toBe('custom_error_bag');
});

test('it flashes message to session', function () {
    Session::shouldReceive('flash')->once()->with('error', 'Test message');

    $builder = ValidationExceptionBuilder::message('Test message')
        ->flash();

    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        // Exception thrown as expected
    }
});

test('it flashes custom message with custom key', function () {
    Session::shouldReceive('flash')->once()->with('custom_key', 'Custom flash message');

    $builder = ValidationExceptionBuilder::message('Test message')
        ->flash('Custom flash message', 'custom_key');

    try {
        $builder->throwException();
    } catch (ValidationException $e) {
        // Exception thrown as expected
    }
});

test('it throws custom exception', function () {
    $builder = ValidationExceptionBuilder::message('Test message')
        ->withException(\RuntimeException::class);

    expect(fn() => $builder->throwException())->toThrow(\RuntimeException::class, 'Test message');
});

test('it uses custom exception callback', function () {
    $builder = ValidationExceptionBuilder::message('Test message')
        ->withExceptionCallback(function ($message, $url, $errorBag) {
            return new \RuntimeException("Custom: $message");
        });

    expect(fn() => $builder->throwException())->toThrow(\RuntimeException::class, 'Custom: Test message');
});

test('it throws exception conditionally with if', function () {
    $builder = ValidationExceptionBuilder::message('Test message');

    expect(fn() => $builder->throwExceptionIf(true))->toThrow(ValidationException::class);
    expect(fn() => $builder->throwExceptionIf(false))->not->toThrow(ValidationException::class);

    expect(fn() => $builder->throwExceptionIf(fn() => true))->toThrow(ValidationException::class);
    expect(fn() => $builder->throwExceptionIf(fn() => false))->not->toThrow(ValidationException::class);
});

test('it throws exception conditionally with unless', function () {
    $builder = ValidationExceptionBuilder::message('Test message');

    expect(fn() => $builder->throwExceptionUnless(false))->toThrow(ValidationException::class);
    expect(fn() => $builder->throwExceptionUnless(true))->not->toThrow(ValidationException::class);

    expect(fn() => $builder->throwExceptionUnless(fn() => false))->toThrow(ValidationException::class);
    expect(fn() => $builder->throwExceptionUnless(fn() => true))->not->toThrow(ValidationException::class);
});
