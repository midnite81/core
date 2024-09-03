# ValidationHandler

## Introduction

`ValidationHandler` is a flexible and powerful class for handling request validation in Laravel applications. It provides an intuitive interface for setting validation rules, customizing error messages, and managing redirection behavior upon validation failure.

## Installation

You can install the package via composer:

```bash
composer require midnite81/core
```

## Basic Usage

### 1. Create a ValidationHandler instance

```php
use Midnite81\Core\Handlers\ValidationHandler;

$handler = new ValidationHandler($request);
$handler = ValidationHandler::make($request);
```

### 2. Set Validation Rules

```php
$handler->setRules([
    'name' => 'required|string',
    'email' => 'required|email',
]);
```

### 3. Set Error Messages (Optional)

```php
$handler->setMessages([
    'name.required' => 'The name field is required.',
    'email.email' => 'Please enter a valid email address.',
]);
```

### 4. Perform Validation

```php
try {
    $handler->validate();
    // Validation passed, proceed with your logic
} catch (ValidationException $e) {
    // Validation failed, exception will be thrown and request redirected
}
```

## Advanced Usage

### Using Form Requests

You can use a FormRequest class in two ways:

1. Passing an instance of FormRequest:

```php
use App\Http\Requests\MyFormRequest;

$handler->setFormRequest(new MyFormRequest());
```

2. Passing the class name as a string:

```php
$handler->setFormRequest(MyFormRequest::class);
```

Both methods will set the rules and messages from the FormRequest. The `ValidationHandler` will use the `rules()` and `messages()` methods of the FormRequest if they exist. If `rules()` doesn't exist or returns an empty array, an exception will be thrown.

### Customizing Redirect Behavior

#### Set a specific URL:

```php
$handler->setRedirectUrl('/error-page');
```

#### Use a closure for dynamic redirection:

```php
$handler->setRedirectUrl(function ($request, $errors) {
    return '/custom-error-page?error=' . $errors->first();
});
```

#### Redirect to a named route:

```php
$handler->setRedirectRoute('error.page', ['type' => 'validation']);
```

#### Redirect back to the previous page:

```php
$handler->setRedirectBack();
```

### Adding Query Parameters and Fragments

```php
$handler->withQueryParameters(['source' => 'validation_error'])
        ->withFragment('error-section');
```

### Managing Input Flashing

By default, input is flashed to the session. You can disable this:

```php
$handler->flashInput(false);
```

### Adding Flash Messages

```php
$handler->withFlashMessage('Validation failed. Please check your input.', 'warning');
```

## Full Example

Here's a complete example showcasing various features:

```php
use Midnite81\Core\Handlers\ValidationHandler;
use Illuminate\Validation\ValidationException;

$handler = ValidationHandler::make($request)
    ->setRules([
        'name' => 'required|string',
        'email' => 'required|email',
    ])
    ->setMessages([
        'name.required' => 'Please enter your name.',
        'email.email' => 'The email address is invalid.',
    ])
    ->setRedirectBack()
    ->withQueryParameters(['error' => 'validation_failed'])
    ->withFragment('form-section')
    ->withFlashMessage('Please correct the errors and try again.', 'error');

try {
    $handler->validate();
    // Validation passed
} catch (ValidationException $e) {
    // Validation failed, user will be redirected with error messages
}
```

This setup will validate the request, and if validation fails, it will redirect back to the previous page with query parameters and a fragment, flash the input, set a flash message, and display the validation errors.

## API Reference

### ValidationHandler Class

#### Static Methods

- `make(?Request $request = null): static`
  Creates a new instance of ValidationHandler.

#### Instance Methods

- `setFormRequest(FormRequest|string $formRequest): self`
  Sets the form request to use for validation rules and messages.

- `setRules(array $rules): self`
  Sets the validation rules.

- `setMessages(array $messages): self`
  Sets the validation error messages.

- `setRedirectUrl(string|Closure $url): self`
  Sets the redirect URL or closure for failed validation.

- `setRedirectRoute(string $route, array $parameters = []): self`
  Sets the redirect route for failed validation.

- `setRedirectBack(): self`
  Sets the redirect behavior to go back to the previous page.

- `withQueryParameters(array $params): self`
  Adds query parameters to the redirect URL.

- `withFragment(?string $fragment): self`
  Adds a fragment to the redirect URL.

- `flashInput(bool $flash = true): self`
  Sets whether to flash input to the session.

- `withFlashMessage(string $message, ?string $key = null): self`
  Sets a flash message for the session.

- `validate(): void`
  Performs the validation.

## Conclusion

The `ValidationHandler` class offers a powerful and flexible way to handle validation in your Laravel applications. By chaining methods, you can easily customize the validation process and error handling to suit your specific needs.

## License

This package is open-sourced software licensed under the MIT license.
