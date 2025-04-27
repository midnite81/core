<?php

namespace Midnite81\Core\Attributes\Contextual;

use Attribute;
use InvalidArgumentException;
use ReflectionParameter;

/**
 * Inject attribute for contextual dependency injection in Laravel 12+.
 *
 * To use this attribute in your Laravel 12+ application, you need to register
 * the InjectServiceProvider in your application's config/app.php providers array:
 *
 * ```php
 * 'providers' => [
 *     // Other providers...
 *     Midnite81\Core\Providers\InjectServiceProvider::class,
 * ],
 * ```
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class Inject
{
    /**
     * Create a new attribute instance.
     */
    public function __construct(public string $implementation) {}

    /**
     * Resolve the implementation for the given attribute.
     *
     * This method is only used in Laravel 12+ when the ContextualAttribute interface exists.
     * For older Laravel versions, this method won't be called.
     *
     * @param self $attribute
     * @param object $container Container implementing the necessary methods
     * @param ReflectionParameter|null $parameter
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public static function resolve(self $attribute, mixed $container, ?ReflectionParameter $parameter = null): mixed
    {
        // Only run validation if we have parameter information
        if ($parameter !== null) {
            $parameterType = $parameter->getType()?->getName();

            if ($parameterType && interface_exists($parameterType)) {
                // Check if the implementation class implements the required interface
                if (!is_subclass_of($attribute->implementation, $parameterType)) {
                    throw new InvalidArgumentException(
                        "The implementation class [{$attribute->implementation}] must implement [{$parameterType}]."
                    );
                }
            }
        }

        return $container->make($attribute->implementation);
    }
}
