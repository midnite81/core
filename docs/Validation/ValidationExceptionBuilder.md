# ValidationExceptionBuilder

`ValidationExceptionBuilder` is a fluent interface for building and throwing validation exceptions in Laravel
applications. It provides a convenient way to create custom validation exceptions with redirects, error messages, and
additional parameters.

## Basic Usage

Here's a quick example of how to use the `ValidationExceptionBuilder`:

```php
use Midnite81\Core\Validation\ValidationExceptionBuilder;

ValidationExceptionBuilder::make('Invalid input')
    ->redirectTo('/form')
    ->flash('Please correct the errors and try again.')
    ->throwException();
```

This will throw a `ValidationException` with the message "Invalid input", redirect the user to '/form', and flash a
message to the session.

## Instantiation

You can create a `ValidationExceptionBuilder` instance in two ways:

1. Using the static `make()` method:
   ```php
   $builder = ValidationExceptionBuilder::make('Custom message');
   ```

2. Direct instantiation:
   ```php
   $builder = new ValidationExceptionBuilder('Custom message');
   ```

If no message is provided, a default message will be used: "There is an error in your form".

## API Reference

### Static Methods

#### `make(string $message = ''): self`

Create a new ValidationExceptionBuilder instance with an optional error message.

#### `message(string $message): self`

Alias for `make()`. Create a new ValidationExceptionBuilder instance with the specified error message.

### Instance Methods

#### `withMessage(string $message): self`

Set a custom message for the exception.

#### `redirectTo(string $url): self`

Set the URL to redirect to after validation failure.

#### `redirectBack(): self`

Set the redirect to go back to the previous URL.

#### `redirectRoute(string $name, array $parameters = []): self`

Set a named route to redirect to after validation failure.

#### `fragment(string $fragment): self`

Set the URL fragment (hash) to append to the redirect URL.

#### `withQueryParameters(array $params): self`

Set query parameters to append to the redirect URL.

#### `errorBag(string $errorBag): self`

Set the error bag name for the validation exception.

#### `flash(?string $message = null, string $key = 'error'): self`

Enable session flashing with an optional custom message and key.

#### `withException(string $exceptionClass): self`

Set the exception class to be thrown.

#### `withExceptionCallback(callable $callback): self`

Set a callback for creating the exception.

#### `throwException(): void`

Throw the configured exception.

#### `throwExceptionIf($condition): void`

Throw the configured exception if the given condition is true.

#### `throwExceptionUnless($condition): void`

Throw the configured exception unless the given condition is true.

## Examples

### Basic Validation Exception

```php
ValidationExceptionBuilder::make('The email is invalid')
    ->redirectBack()
    ->throwException();
```

### Custom Redirect with Query Parameters

```php
ValidationExceptionBuilder::make('Invalid input')
    ->redirectTo('/users')
    ->withQueryParameters(['sort' => 'name', 'order' => 'asc'])
    ->throwException();
```

### Using Named Routes

```php
ValidationExceptionBuilder::make('Access denied')
    ->redirectRoute('dashboard', ['user' => $userId])
    ->throwException();
```

### Flashing Messages

```php
ValidationExceptionBuilder::make('Form submission failed')
    ->redirectBack()
    ->flash('Please correct the errors and try again.', 'warning')
    ->throwException();
```

### Conditional Exception Throwing

```php
$someCondition = true;

ValidationExceptionBuilder::make('Conditional error')
    ->redirectBack()
    ->throwExceptionIf($someCondition);
```

### Custom Exception Class

```php
class MyCustomException extends Exception {}

ValidationExceptionBuilder::make('Something went wrong')
    ->withException(MyCustomException::class)
    ->throwException();
```

### Using Exception Callback

```php
ValidationExceptionBuilder::make('Custom handling required')
    ->withExceptionCallback(function ($message, $url, $errorBag) {
        // Custom logic here
        return new MyCustomException($message);
    })
    ->throwException();
```

### Direct Instantiation with Method Chaining

```php
$builder = new ValidationExceptionBuilder();
$builder->withMessage('Chained message')
        ->redirectTo('/custom-page')
        ->fragment('section1')
        ->throwException();
```
