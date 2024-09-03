# ValidationHandler Usage Guide

The `ValidationHandler` class provides a flexible way to handle request validation in Laravel applications. This guide
will walk you through its usage and features.

## Basic Usage

### 1. Create a ValidationHandler instance

```php
use Midnite81\Core\Handlers\ValidationHandler;

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

If you have a FormRequest class, you can use it directly:

```php
use App\Http\Requests\MyFormRequest;

$handler->setFormRequest(new MyFormRequest());
```

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

This setup will validate the request, and if validation fails, it will redirect back to the previous page with query
parameters and a fragment, flash the input, set a flash message, and display the validation errors.

## Conclusion

The `ValidationHandler` class offers a powerful and flexible way to handle validation in your Laravel applications. By
chaining methods, you can easily customize the validation process and error handling to suit your specific needs.
