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
use Midnite81\Core\Handlers\ValidationHandler;

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
use Midnite81\Core\Handlers\ValidationHandler;

$handler = ValidationHandler::make()
    ->setFormRequest(YourCustomFormRequest::class)
    ->setRedirectRoute('your.error.route')
    ->withFragment('form')
    ->onPass(function ($request) {
        // Handle successful validation
    })
    ->onFail(function ($request, $errors) {
        // Handle failed validation
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

Example usage:

```php
$handler = ValidationHandler::make()
    ->setRules([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ])
    ->onPass(function ($request) {
        // Handle successful validation
        $user = User::create($request->validated());
        event(new UserRegistered($user));
        
        // Note: You don't need to return or redirect here
        // The ValidationHandler will allow your code to continue
        // to the next step after this callback completes
    });

$handler->validate();

// If we reach here, validation has passed and onPass callback has been executed
// You can now proceed with your next steps, such as redirecting the user
return redirect()->route('dashboard')->with('success', 'Registration successful!');
```

The `onPass` method allows you to:

- Perform immediate actions with validated data
- Trigger events or queue jobs based on the validated input
- Prepare data for the next step in your process

Remember, the `onPass` callback doesn't need to return anything or handle redirection. It's designed to execute its
logic and then allow your code to continue to the next step naturally.

### onFail(Closure $callback)

Define actions to be taken when validation fails.

### finally(Closure $hook)

Define actions to be taken after validation, regardless of whether it passed or failed.

## Benefits

1. **Flexible Redirection**: Offers multiple ways to configure redirection behavior, especially useful for returning to
   specific URLs or specifying a segment after form processing.

2. **Custom Actions**: The `onPass`, `onFail`, and `finally` methods allow you to define custom actions, giving you more
   control over the application flow.

3. **Enhanced FormRequest Integration**: Works standalone or seamlessly with existing FormRequest classes, adding
   powerful features without requiring modifications to your current validation setup.

4. **Cleaner Controllers**: By encapsulating validation logic, including redirection and flash messages, you can keep
   your controllers cleaner and more focused on business logic.

5. **Reusability**: The fluent interface allows for easy reuse of validation logic across different parts of your
   application.

6. **Automatic Dependency Resolution**: The class can automatically resolve its ValidationFactory and Request
   dependencies, making it even easier to use in various contexts.

## Implementation Details

### Constructor

The `ValidationHandler` class has a flexible constructor that can instantiate the `ValidationFactory` and `Request` if
they're not provided:

```php
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ValidationHandler
{
    protected ValidationFactory $validationFactory;
    protected Request $request;

    public function __construct(ValidationFactory $validationFactory = null, Request $request = null)
    {
        $this->validationFactory = $validationFactory ?? App::make(ValidationFactory::class);
        $this->request = $request ?? App::make(Request::class);

        $this->redirectBehavior = function () {
            return url()->previous();
        };
    }

    // ... rest of the class implementation ...
}
```

This allows for flexible instantiation:

1. Without any parameters: `$handler = new ValidationHandler();`
2. With only the ValidationFactory: `$handler = new ValidationHandler($validationFactory);`
3. With both ValidationFactory and Request: `$handler = new ValidationHandler($validationFactory, $request);`

### Factory Method

The `make` static method provides a convenient way to create instances:

```php
public static function make(ValidationFactory $validationFactory = null, Request $request = null): static
{
    return new static($validationFactory, $request);
}
```

## Full Implementation Example

Here's how you might use the `ValidationHandler` in a controller:

```php
use Midnite81\Core\Handlers\ValidationHandler;

class YourController extends Controller
{
    public function store()
    {
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
                // Custom failure handling, if needed
            })
            ->finally(function ($request, $passed) {
                // Actions to perform regardless of validation outcome
            });

        $handler->validate();

        // If we reach here, validation passed
        return redirect()->route('form.success')->with('message', 'Form submitted successfully!');
    }
}
```

## Conclusion

The `ValidationHandler` class provides a powerful and flexible way to handle form validation in Laravel applications. By
offering a fluent interface, easy integration with existing FormRequest classes, and automatic dependency resolution, it
simplifies complex validation scenarios while keeping your code clean and maintainable.

Whether you're working on a simple form or a complex multi-step process, the `ValidationHandler` can help streamline
your validation logic and improve the overall structure of your application.
