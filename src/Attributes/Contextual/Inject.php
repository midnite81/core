<?php

namespace Midnite81\Core\Attributes\Contextual;

use Attribute;
use Illuminate\Contracts\Container\ContextualAttribute;
use InvalidArgumentException;
use ReflectionParameter;

/**
 * Inject attribute for contextual dependency injection in Laravel 12+.
 *
 * This attribute allows you to specify concrete implementations for interfaces
 * directly at the parameter level, providing an alternative to traditional
 * contextual binding in Laravel applications.
 *
 * Usage Examples:
 *
 * 1. Basic Usage:
 *    ```php
 *    public function __construct(
 *        #[Inject(MyConcreteClass::class)] MyInterface $service
 *    ) {
 *        // $service will be an instance of MyConcreteClass
 *    }
 *    ```
 *
 * 2. In Controller Methods:
 *    ```php
 *    public function show(
 *        #[Inject(CustomUserRepository::class)] UserRepositoryInterface $repository,
 *        int $userId
 *    ) {
 *        return $repository->findById($userId);
 *    }
 *    ```
 *
 * 3. With Multiple Parameters:
 *    ```php
 *    public function process(
 *        #[Inject(FileLogger::class)] LoggerInterface $logger,
 *        #[Inject(ApiEventDispatcher::class)] EventDispatcherInterface $dispatcher
 *    ) {
 *        // Both dependencies will be resolved to their specified implementations
 *    }
 *    ```
 *
 * Note: This attribute requires Laravel 12+ as it implements the ContextualAttribute
 * interface. For older Laravel versions, you'll need to use traditional contextual
 * binding in your service providers.
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class Inject implements ContextualAttribute
{
    /**
     * Create a new attribute instance.
     *
     * @param string $implementation The concrete class that should be injected
     */
    public function __construct(public string $implementation) {}

    /**
     * Resolve the implementation for the given attribute.
     *
     * This method is only used in Laravel 12+ when the ContextualAttribute interface exists.
     * For older Laravel versions, this method won't be called.
     *
     * @param self $attribute Current attribute instance
     * @param object $container Container implementing the necessary methods
     * @param ReflectionParameter|null $parameter Reflection information about the parameter
     * @return mixed The resolved implementation
     *
     * @throws InvalidArgumentException When the implementation doesn't implement the required interface
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
