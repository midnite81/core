<?php

declare(strict_types=1);

namespace Midnite81\Core\Handlers;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ValidationHandler
{
    protected array $rules = [];

    protected array $messages = [];

    protected Closure|string $redirectBehavior;

    protected bool $flashInput = true;

    protected ?string $flashMessage = null;

    protected string $flashMessageKey = 'error';

    protected array $queryParameters = [];

    protected ?string $fragment = null;

    protected ?Closure $passCallback = null;

    protected ?Closure $failCallback = null;

    protected ?Closure $finallyCallback = null;

    protected ?string $errorBag = null;

    protected ?FormRequest $formRequest = null;

    protected ValidationFactory $validationFactory;

    protected Request $request;

    /**
     * Constructor method.
     *
     * @param ValidationFactory|null $validationFactory An instance of ValidationFactory.
     * @param Request|null $request An instance of Request.
     *
     * @throws BindingResolutionException
     */
    public function __construct(?ValidationFactory $validationFactory = null, ?Request $request = null)
    {
        $this->validationFactory = $validationFactory ?? app()->make(ValidationFactory::class);
        $this->request = $request ?? app()->make(Request::class);

        $this->redirectBehavior = function () {
            return url()->previous();
        };
    }

    /**
     * Factory method to instantiate the class.
     *
     * @param ValidationFactory|null $validationFactory An instance of ValidationFactory.
     * @param Request|null $request An instance of Request.
     * @return static Returns a new instance of the class.
     * @throws BindingResolutionException
     */
    public static function make(?ValidationFactory $validationFactory = null, ?Request $request = null): static
    {
        return new static($validationFactory, $request);
    }

    /**
     * Sets the form request for the current instance. The form request can be
     * an instance of FormRequest or a valid class name that extends FormRequest.
     *
     * @param FormRequest|string $formRequest An instance of FormRequest or
     *                                        a valid class name that extends FormRequest.
     * @return self The current instance for method chaining.
     *
     * @throws \InvalidArgumentException If the provided class name is not a valid FormRequest
     *                                   class or if the rules method does not return validation rules.
     */
    public function setFormRequest(FormRequest|string $formRequest): self
    {
        if (is_string($formRequest)) {
            if (!class_exists($formRequest) || !is_subclass_of($formRequest, FormRequest::class)) {
                throw new \InvalidArgumentException('The provided class name must be a valid FormRequest class.');
            }
            $formRequest = new $formRequest();
        }

        if (!$formRequest instanceof FormRequest) {
            throw new \InvalidArgumentException('The provided argument must be an instance of FormRequest or a valid class name.');
        }

        $this->formRequest = $formRequest;
        $this->rules = method_exists($formRequest, 'rules') ? $formRequest->rules() : [];
        $this->messages = method_exists($formRequest, 'messages') ? $formRequest->messages() : [];

        if (empty($this->rules)) {
            throw new \InvalidArgumentException('The provided FormRequest class must have a rules() method that returns validation rules.');
        }

        if (method_exists($formRequest, 'errorBag')) {
            $this->errorBag = $formRequest->errorBag();
        }

        return $this;
    }

    /**
     * Sets the validation rules for the current instance.
     *
     * @param array $rules An array of validation rules.
     * @return self The current instance for method chaining.
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Sets the validation messages for the current instance.
     *
     * @param array $messages An array of validation messages.
     * @return self The current instance for method chaining.
     */
    public function setMessages(array $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Sets the URL to which the system should redirect.
     *
     * @param string|Closure $url The URL or a Closure that returns the URL.
     * @return self Returns the current instance for method chaining.
     */
    public function setRedirectUrl(string|Closure $url): self
    {
        $this->redirectBehavior = $url;

        return $this;
    }

    /**
     * Sets the route to which the system should redirect with optional parameters.
     *
     * @param string $route The name of the route.
     * @param array $parameters Optional parameters for the route.
     * @return self Returns the current instance for method chaining.
     */
    public function setRedirectRoute(string $route, array $parameters = []): self
    {
        $this->redirectBehavior = function () use ($route, $parameters) {
            return route($route, $parameters);
        };

        return $this;
    }

    /**
     * Sets the redirect behavior to redirect back to the previous URL.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setRedirectBack(): self
    {
        $this->redirectBehavior = function () {
            return url()->previous();
        };

        return $this;
    }

    /**
     * Sets the query parameters to be used.
     *
     * @param array $params An associative array of query parameters.
     * @return self Returns the current instance for method chaining.
     */
    public function withQueryParameters(array $params): self
    {
        $this->queryParameters = $params;

        return $this;
    }

    /**
     * Sets the fragment component of the URL.
     *
     * @param string|null $fragment The fragment or null if no fragment is to be set.
     * @return self Returns the current instance for method chaining.
     */
    public function withFragment(?string $fragment): self
    {
        $this->fragment = $fragment;

        return $this;
    }

    /**
     * Sets whether the input should be flashed for the next request.
     *
     * @param bool $flash Indicates whether the input should be flashed. Defaults to true.
     * @return self Returns the current instance for method chaining.
     */
    public function flashInput(bool $flash = true): self
    {
        $this->flashInput = $flash;

        return $this;
    }

    /**
     * Sets a flash message to be used in the application.
     *
     * @param string $message The flash message to be set.
     * @param string|null $key An optional key to categorize the flash message.
     * @return self Returns the current instance for method chaining.
     */
    public function withFlashMessage(string $message, ?string $key = null): self
    {
        $this->flashMessage = $message;
        if ($key !== null) {
            $this->flashMessageKey = $key;
        }

        return $this;
    }

    /**
     * Sets the callback function to be executed on pass condition.
     *
     * @param Closure $callback The callback function to be executed.
     * @return self Returns the current instance for method chaining.
     */
    public function onPass(Closure $callback): self
    {
        $this->passCallback = $callback;

        return $this;
    }

    /**
     * Sets the callback to be executed on failure.
     *
     * @param Closure $callback The callback function to be triggered on failure.
     * @return self Returns the current instance for method chaining.
     */
    public function onFail(Closure $callback): self
    {
        $this->failCallback = $callback;

        return $this;
    }

    /**
     * Registers a hook to be executed after validation.
     *
     * @param Closure $hook The Closure to be called after validation.
     * @return self Returns the current instance for method chaining.
     */
    public function finally(Closure $hook): self
    {
        $this->finallyCallback = $hook;

        return $this;
    }

    /**
     * Sets the error bag that should be used.
     *
     * @param string $errorBag The name of the error bag.
     * @return self Returns the current instance for method chaining.
     */
    public function setErrorBag(string $errorBag): self
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    /**
     * Validates the current request data against the specified rules and messages.
     * If validation fails, it creates a ValidationException with the appropriate
     * redirect URL and error messages and throws it.
     *
     * @return void
     */
    public function validate(): void
    {
        $this->authorizeFormRequest();

        $validator = $this->validationFactory->make($this->request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($this->failCallback) {
                $shouldProceed = ($this->failCallback)($this->request, $errors);
                if ($shouldProceed === false) {
                    return;
                }
            }

            $redirectUrl = $this->redirectBehavior instanceof Closure
                ? ($this->redirectBehavior)($this->request, $errors)
                : $this->redirectBehavior;

            if (!empty($this->queryParameters)) {
                $redirectUrl = $redirectUrl . (parse_url($redirectUrl, PHP_URL_QUERY) ? '&' : '?') . http_build_query($this->queryParameters);
            }

            if ($this->fragment) {
                $redirectUrl .= '#' . $this->fragment;
            }

            $exception = ValidationException::withMessages($errors->toArray())
                ->redirectTo($redirectUrl);

            if ($this->errorBag) {
                $exception->errorBag($this->errorBag);
            }

            if ($this->flashInput) {
                $this->request->flash();
            }

            if ($this->flashMessage) {
                session()->flash($this->flashMessageKey, $this->flashMessage);
            }

            if ($this->finallyCallback) {
                ($this->finallyCallback)($this->request, false);
            }

            throw $exception;
        } else {
            if ($this->passCallback) {
                ($this->passCallback)($this->request);
            }

            if ($this->finallyCallback) {
                ($this->finallyCallback)($this->request, true);
            }
        }
    }

    protected function authorizeFormRequest(): void
    {
        if ($this->formRequest && method_exists($this->formRequest, 'authorize') && !$this->formRequest->authorize()) {
            throw new AuthorizationException('This action is unauthorized.');
        }
    }
}
