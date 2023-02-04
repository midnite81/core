# Arrays

A PHP class for array manipulation. It includes functions for sorting arrays, imploding arrays, renaming keys in arrays,
and more.

## Features

- `arrayOrderBy`: Sorts an array by a specified order
- `implodeAnd`: Implodes an array with the provided separator except for the last item which it prefixes with and
- `implodeOr`: Implodes an array with the provided separator except for the last item which it prefixes with or
- `implodePenultimate`: Implodes an array with the provided separator except for the last item which it prefixes with a
  word provided as a parameter
- `renameKey`: Renames a key in an array, overwriting the existing key if it exists, and removes the old key

### Usage

#### arrayOrderBy
```php
use Midnite81\Core\Helpers\Arrays;

$array = [
    [
        'name' => 'John Doe',
        'age' => 32
    ],
    [
        'name' => 'Jane Doe',
        'age' => 29
    ],
];

$sortedArray = Arrays::arrayOrderBy($array, 'name', SORT_ASC);
// returns
//[    
//    ['name' => 'Jane Doe', 'age' => 29],
//    ['name' => 'John Doe', 'age' => 32]
//];
```

#### implodeAnd
```php
use Midnite81\Core\Helpers\Arrays;

$names = ['John', 'Jane', 'Jim'];
$implodedNames = Arrays::implodeAnd($names);
// returns 'John, Jane and Jim'

$array = [
    'old_key' => 'value'
];
```

#### implodeOr
```php
use Midnite81\Core\Helpers\Arrays;

$names = ['John', 'Jane', 'Jim'];
$implodedNames = Arrays::implodeOr($names);
// returns 'John, Jane or Jim'

$array = [
    'old_key' => 'value'
];
```

#### implodePenultimate
```php
use Midnite81\Core\Helpers\Arrays;

$names = ['John', 'Jane', 'Jim'];
$implodedNames = Arrays::implodePenultimate($names, ' &');
// returns 'John, Jane & Jim'

$array = [
    'old_key' => 'value'
];
```

#### renameKey
```php
use Midnite81\Core\Helpers\Arrays;

Arrays::renameKey($array, 'old_key', 'new_key');
//returns [
//    'new_key' => 'value'
//];

```

You can also pass a fourth argument as true to throw an error if the new key already exists in the array to prevent
over writing the existing key.
