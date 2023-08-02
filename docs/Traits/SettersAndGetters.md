# Getters and Setters Trait Documentation

The GettersAndSetters trait in the Midnite81\Core\Traits\Entities namespace provides magic methods for getter and setter
functionality. This functionality comes from the combined use of the FluentSetters and Getters traits. Despite the
flexibility that magic methods offer, their usage should be approached with caution. Extensive use of magic methods can
potentially decrease code clarity and maintainability. Therefore, strongly typed methods are preferred for getter and
setter functionalities whenever possible.

## How to use the GettersAndSetters trait

```php
<?php

declare(strict_types=1);

namespace YourNamespace;

use Midnite81\Core\Attributes\MagicMethods\Getters\CannotGetByMagicMethod;use Midnite81\Core\Traits\Entities\GettersAndSetters;
use Midnite81\Core\Attributes\MagicMethods\Setters\CanSetViaMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Getters\CanAccessViaMagicMethod;

class YourClass
{
    use GettersAndSetters;

    private string $name;
    
    #[CannotGetByMagicMethod]
    private string $location;
}
```

In this example, we are using the GettersAndSetters trait in a class. The trait enables us to use dynamic getter and
setter methods. You will notice that there is an attribute on the `$location` property. This attribute prevents the 
property from being accessed via a magic method.

## Using GettersAndSetters trait with Attributes

The GettersAndSetters trait can also be used with Attributes to define whether a property can be accessed or set using
magic methods.

```php
<?php

declare(strict_types=1);

namespace YourNamespace;

use Midnite81\Core\Attributes\MagicMethods\Getters\MagicMethodGetExplicit;use Midnite81\Core\Attributes\MagicMethods\Setters\MagicMethodSetExplicit;use Midnite81\Core\Traits\Entities\GettersAndSetters;
use Midnite81\Core\Attributes\MagicMethods\Setters\CanSetViaMagicMethod;
use Midnite81\Core\Attributes\MagicMethods\Getters\CanAccessViaMagicMethod;

#[MagicMethodGetExplicit]
#[MagicMethodSetExplicit]
class YourClass
{
    use GettersAndSetters;

    #[CanSetViaMagicMethod]
    #[CanAccessViaMagicMethod]
    private string $name;
    
    private string $location;
}
```

In this example, we have used the `MagicMethodGetExplicit` and `MagicMethodSetExplicit` attributes to define that the
properties have to be explicitly marked with the `CanSetViaMagicMethod` and `CanAccessViaMagicMethod` attributes in 
order to be accessed or set via magic methods. In this example, only the `$name` property can be accessed or set via
the magic methods.

## Exceptions

While using this trait, be aware of the following exceptions which might be thrown:

`CannotBeSetByMagicMethodException`: This is thrown when you attempt to set a property that has the
`CannotBeSetByMagicMethod` attribute.

`CannotGetByMagicMethodException`: This is thrown when you attempt to access a property that has the
`CannotGetByMagicMethod` attribute.

`PropertyRequiresCanSetViaMagicMethodAttributeException`: This is thrown when you try to set a property which requires 
the CanSetViaMagicMethod attribute but the attribute is not present.

`ReflectionException`: This is a general exception which might be thrown when reflection fails.
