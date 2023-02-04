# UUID Generator

**Class:** \Midnite81\Core\Services\UuidGenerator
**Interface:** \Midnite81\Core\Contracts\Services\UuidGeneratorInterface

The generate method in this class returns a uuid v4 string. This is useful for generating unique identifiers for your
application. 

## Usage

```php
use \Midnite81\Core\Contracts\Services\UuidGeneratorInterface;

$uuid = app(UuidGeneratorInterface::class)->generate();
```
