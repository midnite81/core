<?php

namespace Tests\Handlers;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Midnite81\Core\Handlers\ValidationHandler;
use Midnite81\Core\Tests\CoreTestCase;

uses(CoreTestCase::class, WithoutMiddleware::class);

beforeEach(function () {
    // Automatically handles the session middleware
    $request = Request::create('/', 'POST');
    $request->setLaravelSession($this->app['session.store']);
    $this->app['request'] = $request;
    $this->validationFactory = $this->app->make(ValidationFactory::class);
});

test('it can be instantiated', function () {
    $handler = new ValidationHandler($this->validationFactory, request());
    expect($handler)->toBeInstanceOf(ValidationHandler::class);
});

test('it can be created using make method', function () {
    $handler = ValidationHandler::make($this->validationFactory, request());
    expect($handler)->toBeInstanceOf(ValidationHandler::class);
});

test('it validates successfully with valid data', function () {
    $request = Request::create('/', 'POST', ['name' => 'John Doe', 'email' => 'john@example.com']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

    $hasErrored = false;
    try {
        $handler->validate();
    } catch (Exception $e) {
        $hasErrored = true;
    }

    expect($hasErrored)->toBeFalse();
});

test('it throws ValidationException with invalid data', function () {
    $request = Request::create('/', 'POST', ['name' => '', 'email' => 'not-an-email']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

    expect(fn () => $handler->validate())->toThrow(ValidationException::class);
});

test('it uses custom error messages', function () {
    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->setMessages(['name.required' => 'Custom error message for name']);

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($e->errors()['name'][0])->toBe('Custom error message for name');
    }
});

test('it sets redirect URL', function () {
    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->setRedirectUrl('/custom-error-page');

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($e->redirectTo)->toBe('/custom-error-page');
    }
});

test('it sets redirect route', function () {
    Route::get('/error-page', function () {
        return 'Error Page';
    })->name('error.page');

    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->setRedirectRoute('error.page', ['type' => 'validation']);

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($e->redirectTo)->toBe(route('error.page', ['type' => 'validation']));
    }
});

test('it adds query parameters to redirect URL', function () {
    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->setRedirectUrl('/error-page')
        ->withQueryParameters(['source' => 'validation_error']);

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($e->redirectTo)->toBe('/error-page?source=validation_error');
    }
});

test('it adds fragment to redirect URL', function () {
    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->setRedirectUrl('/error-page')
        ->withFragment('error-section');

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($e->redirectTo)->toBe('/error-page#error-section');
    }
});

test('it uses form request for rules and messages', function () {
    $formRequest = new class extends FormRequest
    {
        public function rules()
        {
            return ['name' => 'required'];
        }

        public function messages()
        {
            return ['name.required' => 'Name is required from form request'];
        }

        public function errorBag()
        {
            return 'custom_error_bag';
        }
    };

    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setFormRequest($formRequest);

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($e->errors()['name'][0])->toBe('Name is required from form request');
        expect($e->errorBag)->toBe('custom_error_bag');
    }
});

test('it flashes input to session when validation fails', function () {
    $request = Request::create('/', 'POST', ['name' => 'John']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['email' => 'required|email'])
        ->flashInput();

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect(session()->hasOldInput('name'))->toBeTrue();
        expect(session()->getOldInput('name'))->toBe('John');
    }
});

test('it sets flash message when validation fails', function () {
    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->withFlashMessage('Validation failed', 'error');

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect(session('error'))->toBe('Validation failed');
    }
});

test('it executes after validation hook', function () {
    $request = Request::create('/', 'POST', ['name' => 'John Doe']);
    $request->setLaravelSession($this->app['session.store']);

    $hookCalled = false;
    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->finally(function ($request, $passed) use (&$hookCalled) {
            $hookCalled = true;
            expect($passed)->toBeTrue();
        });

    $handler->validate();
    expect($hookCalled)->toBeTrue();
});

test('it executes after validation hook on failure', function () {
    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $hookCalled = false;
    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->finally(function ($request, $passed) use (&$hookCalled) {
            $hookCalled = true;
            expect($passed)->toBeFalse();
        });

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($hookCalled)->toBeTrue();
    }
});

test('it sets custom error bag', function () {
    $request = Request::create('/', 'POST', ['name' => '']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setRules(['name' => 'required'])
        ->setErrorBag('custom_error_bag');

    try {
        $handler->validate();
    } catch (ValidationException $e) {
        expect($e->errorBag)->toBe('custom_error_bag');
    }
});

test('it checks authorization for form request', function () {
    $formRequest = new class extends FormRequest
    {
        public function rules()
        {
            return ['name' => 'required'];
        }

        public function authorize()
        {
            return false;
        }
    };

    $request = Request::create('/', 'POST', ['name' => 'John Doe']);
    $request->setLaravelSession($this->app['session.store']);

    $handler = ValidationHandler::make($this->validationFactory, $request)
        ->setFormRequest($formRequest);

    expect(fn () => $handler->validate())->toThrow(AuthorizationException::class);
});
