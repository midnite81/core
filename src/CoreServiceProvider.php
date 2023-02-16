<?php

declare(strict_types=1);

namespace Midnite81\Core;

use Illuminate\Support\ServiceProvider;
use Midnite81\Core\Contracts\Services\CounterInterface;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Contracts\Services\UuidGeneratorInterface;
use Midnite81\Core\Services\Counter;
use Midnite81\Core\Services\Execute;
use Midnite81\Core\Services\UuidGenerator;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/core-ignition.php' => config_path('core-ignition.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->app->bind(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->alias(UuidGeneratorInterface::class, 'm81-uuid');
        $this->app->bind(ExecuteInterface::class, Execute::class);
        $this->app->bind(CounterInterface::class, Counter::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/core-ignition.php', 'core-ignition');
    }

    /**
     * {@inheritDoc}
     */
    public function provides(): array
    {
        return [
            UuidGeneratorInterface::class,
            ExecuteInterface::class,
            'm81-uuid',
            CounterInterface::class,
        ];
    }
}
