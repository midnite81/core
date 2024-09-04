# ValidationHandler Documentation

## Purpose

The `ValidationHandler` class is designed to streamline and enhance the validation process in Laravel applications. It provides a flexible and powerful way to handle form validation, especially in cases where you need more control over the validation flow, redirection, and post-validation actions.

## Key Features

1. Flexible validation rules and messages setup
2. Customizable redirection behavior
3. Support for query parameters and URL fragments
4. Input flashing and session message flashing
5. Callbacks for pass and fail scenarios

## Usage with Existing FormRequest Child Classes

One of the primary strengths of the `ValidationHandler` is its ability to work seamlessly with your existing FormRequest child classes. Here's how you can leverage this:

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

By using `setFormRequest()`, you can easily incorporate your existing FormRequest classes into the `ValidationHandler` workflow, maintaining your current validation rules and messages while gaining additional control over the process.

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

### onPass(Closure $callback) and onFail(Closure $callback)

Define actions to be taken on successful or failed validation.

## Benefits

1. **Flexible Redirection**: This class was created to handle cases where you need to return to specific URLs or specify a segment after form processing. It offers multiple ways to configure redirection behavior.

2. **Custom Actions**: The `onPass` and `onFail` methods allow you to define custom actions for successful and failed validations, giving you more control over the application flow.

3. **Enhanced FormRequest Integration**: While it works standalone, the `ValidationHandler` shines when used with existing FormRequest classes, adding powerful features without requiring you to modify your current validation setup.

4. **Cleaner Controllers**: By encapsulating validation logic, including redirection and flash messages, you can keep your controllers cleaner and more focused on business logic.

## Implementation Example

```php
class YourController extends Controller
{
    public function store(Request $request)
    {
        $handler = ValidationHandler::make($request)
            ->setFormRequest(YourCustomFormRequest::class)
            ->setRedirectRoute('form.error')
            ->withFragment('error-section')
            ->withFlashMessage('Please correct the errors below.')
            ->onPass(function ($request) {
                // Save the validated data
                // Redirect to success page
            });

        $handler->validate();

        // If we reach here, validation passed
        return redirect()->route('form.success')->with('message', 'Form submitted successfully!');
    }
}
```

By using the `ValidationHandler`, you gain fine-grained control over the validation process while keeping your controller methods clean and focused on their primary responsibilities.
