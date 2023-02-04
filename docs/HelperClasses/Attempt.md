# Attempt

This class provides a static method for attempting to run a closure and capturing the result or any exception that is
thrown.

## Method: attempt

### Parameters
- `Closure` $closure: The closure to be attempted.

### Return
- `AttemptEntity`: An instance of `AttemptEntity` containing the result of the closure, or the exception that was 
- thrown during the attempt.

### Example
```php
use Midnite81\Core\Helpers\Attempt;

$result = Attempt::attempt(function () {
    return 'Hello World';
});

if ($result->successful) { 
    echo $result->result;
}

if ($result->hasErrored) {
    echo $result->throwable->getMessage();
}
```
