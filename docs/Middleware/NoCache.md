## NoCache
**Class:** \Midnite81\Core\Http\Middleware\NoCache

This middleware adds cache busting headers to the request. This is useful for ensuring that the latest version of the
route is being used.

### Usage

You can use it directly on the route as follows;
```php
Route::get('/', function () {
    return view('welcome');
})->middleware(\Midnite81\Core\Http\Middleware\NoCache::class);
```

If you add it to the `app/Http/Kernel.php` file, under the $routeMiddleware property, you can use it by its alias.
```php
protected $routeMiddleware = [
    'no-cache' => \Midnite81\Core\Http\Middleware\NoCache::class,
];
```
```php
Route::get('/', function () {
    return view('welcome');
})->middleware('no-cache');
```
