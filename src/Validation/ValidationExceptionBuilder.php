<?php

namespace Midnite81\Core\Validation;

use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class ValidationExceptionBuilder
{
    protected string $message;
    protected string $redirectUrl;
    protected ?string $fragment = null;
    protected array $queryParameters = [];
    protected ?string $routeName = null;
    protected array $routeParameters = [];
    protected ?string $errorBag = null;
    protected bool $shouldFlash = false;
    protected string $flashKey = 'error';
    protected ?string $flashMessage = null;
    protected string $exceptionClass = ValidationException::class;
    protected mixed $exceptionCallback = null;

    /**
     * Create a new ValidationExceptionBuilder instance.
     *
     * @param string $message The validation error message.
     */
    protected function __construct(string $message)
    {
        $this->message = $message;
        $this->redirectUrl = URL::previous();
    }

    /**
     * Create a new ValidationExceptionBuilder instance with the specified error message.
     *
     * @param string $message The validation error message.
     * @return self
     */
    public static function message(string $message): self
    {
        return new self($message);
    }

    /**
     * Set the URL to redirect to after validation failure.
     *
     * @param string $url The URL to redirect to.
     * @return self
     */
    public function redirectTo(string $url): self
    {
        $this->redirectUrl = $url;
        $this->routeName = null; // Reset route if URL is set directly
        return $this;
    }

    /**
     * Set the redirect to go back to the previous URL.
     *
     * @return self
     */
    public function redirectBack(): self
    {
        $this->redirectUrl = URL::previous();
        $this->routeName = null; // Reset route if redirecting back
        return $this;
    }

    /**
     * Set a named route to redirect to after validation failure.
     *
     * @param string $name The name of the route.
     * @param array $parameters The parameters for the route.
     * @return self
     */
    public function redirectRoute(string $name, array $parameters = []): self
    {
        $this->routeName = $name;
        $this->routeParameters = $parameters;
        return $this;
    }

    /**
     * Set the URL fragment (hash) to append to the redirect URL.
     *
     * @param string $fragment The URL fragment.
     * @return self
     */
    public function fragment(string $fragment): self
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     * Set query parameters to append to the redirect URL.
     *
     * @param array $params An associative array of query parameters.
     * @return self
     */
    public function withQueryParameters(array $params): self
    {
        $this->queryParameters = $params;
        return $this;
    }

    /**
     * Set the error bag name for the validation exception.
     *
     * @param string $errorBag The name of the error bag.
     * @return self
     */
    public function errorBag(string $errorBag): self
    {
        $this->errorBag = $errorBag;
        return $this;
    }

    /**
     * Enable session flashing with an optional custom message and key.
     *
     * @param string|null $message The message to flash (defaults to the validation message if null).
     * @param string $key The key to use for flashing (defaults to 'error').
     * @return self
     */
    public function flash(?string $message = null, string $key = 'error'): self
    {
        $this->shouldFlash = true;
        $this->flashMessage = $message;
        $this->flashKey = $key;
        return $this;
    }

    /**
     * Set the exception class to be thrown.
     *
     * @param string $exceptionClass The fully qualified class name of the exception.
     * @return self
     * @throws \InvalidArgumentException If the class is not a subclass of Exception.
     */
    public function withException(string $exceptionClass): self
    {
        if (!is_subclass_of($exceptionClass, Exception::class)) {
            throw new \InvalidArgumentException("The provided class must be a subclass of Exception.");
        }
        $this->exceptionClass = $exceptionClass;
        return $this;
    }

    /**
     * Set a callback for creating the exception.
     *
     * @param callable $callback The callback function for creating the exception.
     * @return self
     */
    public function withExceptionCallback(callable $callback): self
    {
        $this->exceptionCallback = $callback;
        return $this;
    }

    /**
     * Throw the configured exception.
     *
     * @throws Exception
     */
    public function throwException(): void
    {
        $url = $this->buildUrl();

        if ($this->exceptionCallback) {
            $exception = call_user_func($this->exceptionCallback, $this->message, $url, $this->errorBag);
        } else {
            $exception = $this->createDefaultException($url);
        }

        if ($this->shouldFlash) {
            Session::flash($this->flashKey, $this->flashMessage ?? $this->message);
        }

        throw $exception;
    }

    /**
     * Throw the configured exception if the given condition is true.
     *
     * @param bool|callable $condition A boolean value or a callback that returns a boolean.
     * @throws Exception
     */
    public function throwExceptionIf($condition): void
    {
        $shouldThrow = is_callable($condition) ? $condition() : $condition;

        if ($shouldThrow) {
            $this->throwException();
        }
    }

    /**
     * Throw the configured exception unless the given condition is true.
     *
     * @param bool|callable $condition A boolean value or a callback that returns a boolean.
     * @throws Exception
     */
    public function throwExceptionUnless($condition): void
    {
        $shouldNotThrow = is_callable($condition) ? $condition() : $condition;

        if (!$shouldNotThrow) {
            $this->throwException();
        }
    }

    /**
     * Build the complete redirect URL with query parameters and fragment.
     *
     * @return string The complete URL.
     */
    protected function buildUrl(): string
    {
        if ($this->routeName) {
            $url = Route::urlTo($this->routeName, $this->routeParameters);
        } else {
            $url = $this->redirectUrl;
        }

        if (!empty($this->queryParameters)) {
            $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . http_build_query($this->queryParameters);
        }

        if ($this->fragment) {
            $url .= '#' . $this->fragment;
        }

        return $url;
    }

    /**
     * Create the default exception based on the configured exception class.
     *
     * @param string $url The redirect URL.
     * @return Exception
     */
    protected function createDefaultException(string $url): Exception
    {
        if ($this->exceptionClass === ValidationException::class) {
            $exception = ValidationException::withMessages(['message' => $this->message])->redirectTo($url);
            if ($this->errorBag) {
                $exception->errorBag($this->errorBag);
            }
            return $exception;
        }

        return new $this->exceptionClass($this->message);
    }
}
