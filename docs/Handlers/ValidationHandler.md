# ValidationHandler Documentation

## Introduction

The `ValidationHandler` class is designed to streamline and enhance the validation process in Laravel applications.
While Laravel's built-in Validator class and Form Request validation are powerful tools, the `ValidationHandler` offers
a more fluent and reusable approach, especially in scenarios where you can't use Form Request validation directly in
your controller method arguments.

This class provides a flexible and powerful way to handle form validation, offering more control over the validation
flow, redirection, and post-validation actions. It's particularly useful when you need to customize the validation
process beyond what's easily achievable with standard Laravel validation methods.

## Key Features

1. Flexible validation rules and messages setup
2. Seamless integration with existing FormRequest classes
3. Customizable redirection behavior
4. Support for query parameters and URL fragments
5. Input flashing and session message flashing
6. Callbacks for pass, fail, and finally scenarios
7. Automatic resolution of ValidationFactory and Request dependencies

## Installation

You can install the package via composer:

```bash
composer require midnite81/core
```

## Usage

### Basic Usage

```php
use Midnite81\Core\Validation\ValidationHandler;

$handler = ValidationHandler::make()
    ->setRules([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
    ])
    ->setRedirectRoute('form.error')
    ->withFragment('error-section')
    ->withFlashMessage('Please correct the errors below.')
    ->onPass(function ($request) {
        // Handle successful validation
    });

$handler->validate();
```

### Usage with Existing FormRequest Classes

One of the primary strengths of the `ValidationHandler` is its ability to work seamlessly with your existing FormRequest
classes:

```php
use App\Http\Requests\YourCustomFormRequest;
use Midnite81\Core\Validation\ValidationHandler;

$handler = ValidationHandler::make()
    ->setFormRequest(YourCustomFormRequest::class)
    ->setRedirectRoute('your.error.route')
    ->withFragment('form')
    ->onPass(function ($request) {
        // Handle successful validation
    });

$handler->validate();
```

## Main Methods

### setFormRequest(FormRequest|string $formRequest)

Allows you to use an existing FormRequest class for validation rules and messages.

### setRules(array $rules) and setMessages(array $messages)

Manually set validation rules and error messages.

### setRedirectUrl(string|Closure $url), setRedirectRoute(string $route, array $parameters = []), setRedirectBack()

Configure where to redirect on validation failure.

### withQueryParameters(array $params) and withFragment(?string $fragment)

Add query parameters or a fragment to the redirect URL.

### flashInput(bool $flash = true) and withFlashMessage(string $message, ?string $key = null)

Control input flashing and set flash messages for the session.

### onPass(Closure $callback)

Define actions to be taken when validation passes successfully. This method is particularly useful for executing logic
that should occur immediately after successful validation, before proceeding to the next step in your application flow.

### onFail(Closure $callback)

Define optional actions to be taken when validation fails. It's important to note that this method is not mandatory. If
not specified, the default behavior in the `validate()` method will still throw a `ValidationException` with the
appropriate redirect URL and error messages.

Example usage:

```php
$handler->onFail(function ($request, $errors) {
    // Custom failure handling, if needed
    // Note: ValidationException will still be thrown after this callback
    Log::error('Validation failed', ['errors' => $errors->toArray()]);
});
```

### finally(Closure $hook)

Define actions to be taken after validation, regardless of whether it passed or failed.

### validate()

This method performs the actual validation. If validation fails, it will throw a `ValidationException` with the
configured redirect URL and error messages, regardless of whether an `onFail` callback has been specified.

## Full Implementation Example

Here's a comprehensive example of how you might use the `ValidationHandler` in a controller, demonstrating the optional
nature of the `onFail` callback:

```php
use Midnite81\Core\Validation\ValidationHandler;
use Illuminate\Validation\ValidationException;

class YourController extends Controller
{
    public function store()
    {
        try {
            $handler = ValidationHandler::make()
                ->setFormRequest(YourCustomFormRequest::class)
                ->setRedirectRoute('form.error')
                ->withFragment('error-section')
                ->withFlashMessage('Please correct the errors below.')
                ->onPass(function ($request) {
                    // Save the validated data
                    // Trigger any necessary events or jobs
                })
                ->onFail(function ($request, $errors) {
                    // Optional: Custom failure handling
                    // This will be called before the ValidationException is thrown
                    // Unless you return false
                    Log::warning('Form submission failed', ['errors' => $errors->toArray()]);
                })
                ->finally(function ($request, $passed) {
                    // Actions to perform regardless of validation outcome
                    Log::info('Validation attempt', ['passed' => $passed]);
                });

            $handler->validate();

            // If we reach here, validation passed
            return redirect()->route('form.success')->with('message', 'Form submitted successfully!');
        } catch (ValidationException $e) {
            // The ValidationException is automatically thrown by the validate() method
            // when validation fails, whether or not onFail() is used.
            // The exception handling is typically managed by Laravel's exception handler,
            // but you can add custom logic here if needed.
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}
```

In this example, the `onFail` callback is used for optional custom handling (like logging), but the
`ValidationException` will still be thrown automatically by the `validate()` method, ensuring consistent behavior with
Laravel's built-in validation.

## Conclusion

The `ValidationHandler` class provides a powerful and flexible way to handle form validation in Laravel applications. By
offering a fluent interface, easy integration with existing FormRequest classes, and automatic dependency resolution, it
simplifies complex validation scenarios while keeping your code clean and maintainable.

Whether you're working on a simple form or a complex multi-step process, the `ValidationHandler` can help streamline
your validation logic and improve the overall structure of your application. The automatic throwing of
`ValidationException` in the `validate()` method ensures consistent behavior with Laravel's standard validation, while
still allowing for custom failure handling through the optional `onFail` callback.
