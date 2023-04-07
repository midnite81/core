<?php

namespace Midnite81\Core\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Midnite81\Core\Services\DetectStringable;

class LogControllerAndMethod
{
    protected bool $ray = true;

    protected bool $log = true;

    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->setLoggers();

        if (!in_array(app()->environment(), $this->allowableEnvironments()) ||
            !$this->enabled()
        ) {
            return $next($request);
        }

        $route = $request->route();

        if ($route instanceof Route && method_exists($route, 'getActionName')) {
            $routeAction = $route->getActionName();

            if ($routeAction) {
                [$controller, $method] = explode('@', $routeAction);
                $this->log(['Controller' => $controller, 'Method' => $method]);
            }
        } else {
            $this->log('Could not retrieve the actionName from the route');
            $this->log($route);
        }

        return $next($request);
    }

    /**
     * Get the allowable environments from the config
     *
     * @return string[]
     */
    protected function allowableEnvironments(): array
    {
        if (!empty(config('core-middleware.allowable-environments'))) {
            return config('core-middleware.allowable-environments');
        }

        return ['local'];
    }

    /**
     * Log the given data
     */
    protected function log(mixed $loggable): void
    {
        if ($this->ray and function_exists('ray')) {
            try {
                $ray = app(\Spatie\LaravelRay\Ray::class);
                $ray->send($loggable);
            } catch (Exception $e) {
                // do nothing
            }
        }
        if ($this->log) {
            logger($this->needsEncoding($loggable) ? json_encode($loggable) : $loggable);
        }
    }

    /**
     * Check if the middleware is enabled
     */
    protected function enabled(): bool
    {
        return config('core-middleware.enabled', true);
    }

    /**
     * Set which loggers to use from the config
     */
    protected function setLoggers(): void
    {
        if (config('core-middleware.loggers')) {
            $this->ray = config('core-middleware.loggers.ray');
            $this->log = config('core-middleware.loggers.log');
        }
    }

    /**
     * Determines if the $loggable needs to be encoded
     */
    protected function needsEncoding(mixed $loggable): bool
    {
        return DetectStringable::isNotStringable($loggable);
    }
}
