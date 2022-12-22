<?php

declare(strict_types=1);

namespace Midnite81\Core;

use Illuminate\Support\ServiceProvider;
use Midnite81\Core\Contracts\Services\UuidGeneratorInterface;
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
    }

    /**
     * {@inheritDoc}
     */
    public function provides(): array
    {
        return [
            UuidGeneratorInterface::class,
            'm81-uuid',
        ];
    }
}
