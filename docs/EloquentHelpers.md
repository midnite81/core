# Eloquent Helpers

**Class:** Midnite81\Core\Eloquent\Builder

This class allows you to get the query as a string, with its bindings. This is useful for debugging purposes.

### Usage

```php
$query = User::where('id', 1)->whereIn('id', $names);

dd(\Midnite81\Core\Eloquent\Builder::getQueries($query));

// select * from `users` where `id` = 1 and `id` in ('John', 'Jane', 'Joe)
```
