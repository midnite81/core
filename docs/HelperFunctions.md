# Helper Functions

## Uuid

This namespaced function returns a uuid4 string. 

### Usage

```php
use function Midnite81\Core\Functions\uuid;

$uuid = uuid(); // example return: 66fb42bf-ae0c-42c7-8261-13e73c163eb3 
```

## First Value

This returns the first argument which is not null or an empty string.

### Usage

```php
use function Midnite81\Core\Functions\first_value;

$first = first_value(null, null, 'pete'); // returns 'pete'
```
