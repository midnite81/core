<?php

declare(strict_types=1);

namespace Midnite81\Core\Providers;

use Illuminate\Support\ServiceProvider;

class RayMacroProvider extends ServiceProvider
{
    /**
     * @return void
     * @codeCoverageIgnore
     */
    public function boot(): void
    {
        \Spatie\Ray\Ray::macro('inside', function () {
            $args = func_get_args();
            $calledFrom = debug_backtrace()[3] ?? null;

            $method = $calledFrom['function'] ?? null;
            $class = $calledFrom['class'] ?? null;

            $insideMessage = 'Not inside class, method or function';

            if ($class && $method) {
                $insideMessage = "Inside method [{$method}] of class [{$class}]";
            } elseif ($method) {
                $insideMessage = "Inside function {$method}";
            }

            $this->send($insideMessage, ...$args);

            return $this;
        });
    }
}
