<?php

namespace Midnite81\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Midnite81\Core\Attributes\Contextual\Inject;

class InjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // No registration needed in this phase
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Check if we're in Laravel 12+ with contextual attribute support
        if (interface_exists('Illuminate\Container\ContextualBindingBuilder') &&
            method_exists($this->app, 'registerAttributeResolver')) {

            // Register the Inject attribute resolver
            $this->app->registerAttributeResolver(Inject::class, function ($attribute, $container, $parameter) {
                return Inject::resolve($attribute, $container, $parameter);
            });
        }
    }
}
