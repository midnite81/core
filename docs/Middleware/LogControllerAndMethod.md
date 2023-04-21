# Log Controller And Method

The `LogControllerAndMethod` class is a middleware class used to log the controller and method names of incoming HTTP
requests in Laravel applications. This class is particularly useful in debugging and analyzing application traffic.

The middleware class provides two logging options: `Ray` and `Laravel's logger`. The Ray logger sends the data to the Ray
application, while the Laravel logger writes it to the log files. The middleware class can be enabled or disabled in
specific environments by specifying them in the `core-middleware.allowable-environments config` file.

## Implementation

To implement the `LogControllerAndMethod` middleware class in Laravel's `app/Http/Kernel.php` file, follow the steps below:

### Register the Middleware

Register the middleware class in the `$middleware` array of the `app/Http/Kernel.php` file. Add the class to the web
group and give it a unique name in the named group.

```php
protected $middlewareGroups = [
    'web' => [
    // other middleware classes
    \Midnite81\Core\Http\Middleware\LogControllerAndMethod::class,
    ],

    'api' => [
        // other middleware classes
    ],

    'named' => [
        // other middleware classes
        'log.controller.method' => \Midnite81\Core\Http\Middleware\LogControllerAndMethod::class,
    ],
];
```

### Configure the Middleware

Publish the configuration file for the middleware class by running the following command:

```bash
php artisan vendor:publish --provider="Midnite81\Core\Providers\CoreServiceProvider"
```

The configuration file for the middleware class is located in the `config/core-middleware.php` file. The file contains
 the `enabled` option which allows you to enable or disable the middleware class, while the `allowable-environments` 
option allows you to specify the environments where the middleware is allowed to run.

The loggers option specifies which loggers to use. Setting a logger to true enables it, while setting it to false
disables it.

### Using the Middleware

Once the middleware is registered and configured, you can use it in your Laravel application. You can either use it
globally by adding it to the `$middleware` array or selectively by adding it to specific routes or route groups.

For example, to use the middleware globally, add it to the `$middleware` array in the `app/Http/Kernel.php` file:

```php
protected $middleware = [
        // other middleware classes
        \Midnite81\Core\Http\Middleware\LogControllerAndMethod::class,
    ];
```

To use the middleware selectively, add it to specific routes or route groups:

```php
Route::middleware('log.controller.method')->group(function () {
    Route::get('/', function () {
    return view('welcome');
    });
});
```

### Finally

That's it! You have successfully implemented the LogControllerAndMethod middleware class in your Laravel application.
The middleware class will now log the controller and method names of incoming HTTP requests in the specified
environments using the specified loggers.
