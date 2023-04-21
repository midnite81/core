# Time Conversion

Time conversion is a way of converting time from one format to another. This class and helper functions are used to 
make time more readable.

## Caveats

This class is not designed to be used for time calculations. It is designed to be used for converting time from
one format to another. Months and quarters are not exact. They are based on 30 days in a month and 3 months in a quarter.


## Helper functions

```php
use function Midnite81\Core\Functions\{seconds, hours};

seconds(1)->toMilliseconds(); // 1000
hours(2)->andMinutes(30)->toMinutes(); // 150
days(1)->toSeconds(); // 86400
```

## Class based time conversion

## Static implementation

```php
use Midnite81\Core\Converters\TimeConverter as T;

T::seconds(1)->toMilliseconds(); // 1000
T::make()->fromDays(2)->toHours(); // 48
```

### Non-static implementation
```php
use Midnite81\Core\Converters\TimeConverter;

$time = new TimeConverter();
$time->fromSeconds(1)->toMilliseconds(); // 1000
```

## Available methods

### Helper functions
```php
use function Midnite81\Core\Functions\{microseconds, milliseconds, seconds, minutes, hours, days, weeks, months, quarters, years};

microseconds($value);
milliseconds($value);
seconds($value);
minutes($value);
hours($value);
days($value);
weeks($value);
months($value);
quarters($value);
years($value);
```

### Class based
#### Static
```php
use Midnite81\Core\Converters\TimeConverter as T;

T::make($value);
T::microseconds($value);
T::milliseconds($value);
T::seconds($value);
T::minutes($value);
T::hours($value);
T::days($value);
T::weeks($value);
T::months($value);
T::quarters($value);
T::years($value);
```

#### Non-static
```php
use Midnite81\Core\Converters\TimeConverter;

$time = new TimeConverter($value);
$time->fromMicroseconds($value);
$time->fromMilliseconds($value);
$time->fromSeconds($value);
$time->fromMinutes($value);
$time->fromHours($value);
$time->fromDays($value);
$time->fromWeeks($value);
$time->fromMonths($value);
$time->fromQuarters($value);
$time->fromYears($value);
```

#### Chaining methods
```php
->andMicroseconds($value);
->andMilliseconds($value);
->andSeconds($value);
->andMinutes($value);
->andHours($value);
->andDays($value);
->andWeeks($value);
->andMonths($value);
->andQuarters($value);
->andYears($value);
```

### To Methods
```php
->toMicroseconds($round);
->toMilliseconds($round);
->toSeconds($round);
->toMinutes($round);
->toHours($round);
->toDays($round);
->toWeeks($round);
->toMonths($round);
->toQuarters($round);
->toYears($round);
```
