<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Entities;

use Midnite81\Core\Exceptions\MagicMethods\CannotBeSetByMagicMethodException;
use Midnite81\Core\Exceptions\MagicMethods\CannotGetByMagicMethodException;
use Midnite81\Core\Exceptions\MagicMethods\PropertyRequiresCanSetViaMagicMethodAttributeException;

/**
 * GettersAndSetters Trait
 *
 * This trait combines the functionality of both the Getters and FluentSetters traits, providing magic methods
 * for getter and setter functionality. However, the author wants to emphasize that the extensive use of magic
 * methods should be approached with caution, and they prefer strongly typed methods for getter and setter
 * functionalities wherever possible to enhance code clarity and maintainability.
 *
 * The trait allows for dynamic method calls for both getters and setters, offering a flexible approach for
 * accessing and setting properties in classes. It also performs attribute checks to ensure the proper handling
 * of property access and setting.
 */
trait GettersAndSetters
{
    use Getters;
    use FluentSetters;

    /**
     * Handle dynamic method calls for getters and setters.
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     *
     * @throws CannotBeSetByMagicMethodException When attempting to set a property that cannot be set via magic method.
     * @throws CannotGetByMagicMethodException When attempting to get a property that cannot be accessed via magic method.
     * @throws PropertyRequiresCanSetViaMagicMethodAttributeException When attempting to set a property that requires the canSetViaMagicMethod attribute.
     * @throws \ReflectionException When a reflection error occurs.
     */
    public function __call(string $method, array $arguments)
    {
        if (str_starts_with($method, 'get')) {
            return $this->fluentGettersCall($method, $arguments);
        }

        if (str_starts_with($method, 'set')) {
            return $this->fluentSetterCall($method, $arguments);
        }
    }
}
