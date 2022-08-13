<?php

declare(strict_types=1);

namespace Midnite81\Core\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class CarbonMacroProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Carbon::macro('dayDisplay', static function () {
            /* @phpstan-ignore-next-line */
            if (isset($this)) {
                throw new \RuntimeException('Carbon::dayDisplay() must be called statically.');
            }

            /* @phpstan-ignore-next-line */
            return self::this()->format('l, jS F');
        });

        Carbon::macro('dayDisplayWithYear', static function () {
            /* @phpstan-ignore-next-line */
            if (isset($this)) {
                throw new \RuntimeException('Carbon::dayDisplayWithYear() must be called statically.');
            }

            /* @phpstan-ignore-next-line */
            return self::this()->format('l, jS F, Y');
        });

        Carbon::macro('london', static function () {
            /* @phpstan-ignore-next-line */
            if (isset($this)) {
                throw new \RuntimeException('Carbon::london() must be called statically.');
            }

            /* @phpstan-ignore-next-line */
            return self::this()->tz('Europe/London');
        });
    }
}
