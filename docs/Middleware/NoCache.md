# NoCache Middleware

The NoCache middleware adds headers to disable caching of responses. It adds three headers
to the response:

- Cache-Control: no-store, no-cache, must-revalidate, max-age=0
- Cache-Control: post-check=0, pre-check=0
- Pragma: no-cache

This prevents the browser from caching any responses returned by the server. This is useful in scenarios where you want
to ensure that the content being served is always the most up-to-date version.

## Implementation

Either:     
Register the middleware in your app/Http/Kernel.php file:

```php
protected $middleware = [
    // ...
    \Midnite81\Core\Http\Middleware\NoCache::class,
];
```

Or:   
Add it to a route or route group:

```php
protected $routeMiddleware = [
    // ...
    'no-cache' => \Midnite81\Core\Http\Middleware\NoCache::class,
];
```

Then, you can apply the middleware to any route by using the middleware key in your route definition:

```php
Route::get('/example', function () {
    return view('example');
})->middleware('no-cache');
```


