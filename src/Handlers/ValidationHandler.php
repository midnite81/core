<?php

declare(strict_types=1);

namespace Midnite81\Core\Handlers;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class ValidationHandler
 *
 * Handles validation of a given request using specified rules and messages.
 */
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

    /**
     * Constructor for ValidationHandler.
     *
     * @param Request|null $request The request to validate. If null, uses the global request.
     */
    public function __construct(protected ?Request $request = null)
    {
        $this->request = $this->request ?? request();
        $this->redirectBehavior = function () {
            return url()->previous();
        };
    }

    /**
     * Create a new instance of ValidationHandler.
     *
     * @param Request|null $request The request to validate.
     * @return static
     *
     * @example
     * $handler = ValidationHandler::make($request);
     */
    public static function make(?Request $request = null): static
    {
        return new static($request);
    }

    /**
     * Set the form request to use for validation rules and messages.
     *
     * @param FormRequest|class-string $formRequest The form request to use or its class name.
     * @return self
     * @throws \InvalidArgumentException If the provided argument is neither a FormRequest instance nor a valid class name.
     *
     * @example
     * $handler->setFormRequest(new MyFormRequest());
     * // or
     * $handler->setFormRequest(MyFormRequest::class);
     */
    public function setFormRequest(FormRequest|string $formRequest): self
    {
        if (is_string($formRequest)) {
            if (!class_exists($formRequest) || !is_subclass_of($formRequest, FormRequest::class)) {
                throw new \InvalidArgumentException("The provided class name must be a valid FormRequest class.");
            }
            $formRequest = new $formRequest();
        }

        if (!$formRequest instanceof FormRequest) {
            throw new \InvalidArgumentException("The provided argument must be an instance of FormRequest or a valid class name.");
        }

        $this->rules = method_exists($formRequest, 'rules') ? $formRequest->rules() : [];
        $this->messages = method_exists($formRequest, 'messages') ? $formRequest->messages() : [];

        if (empty($this->rules)) {
            throw new \InvalidArgumentException("The provided FormRequest class must have a rules() method that returns validation rules.");
        }

        return $this;
    }


    /**
     * Set the validation rules.
     *
     * @param array $rules The validation rules to use.
     * @return self
     *
     * @example
     * $handler->setRules(['name' => 'required|string', 'email' => 'required|email']);
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Set the validation error messages.
     *
     * @param array $messages The validation error messages to use.
     * @return self
     *
     * @example
     * $handler->setMessages(['name.required' => 'The name field is required.']);
     */
    public function setMessages(array $messages): self
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * Set the redirect URL or closure for failed validation.
     *
     * @param string|Closure $url The URL or closure to use for redirection.
     * @return self
     *
     * @example
     * $handler->setRedirectUrl('/error-page');
     * // or
     * $handler->setRedirectUrl(function ($request, $errors) {
     *     return '/custom-error-page?error=' . $errors->first();
     * });
     */
    public function setRedirectUrl(string|Closure $url): self
    {
        $this->redirectBehavior = $url;
        return $this;
    }

    /**
     * Set the redirect route for failed validation.
     *
     * @param string $route The route name to redirect to.
     * @param array $parameters The route parameters.
     * @return self
     *
     * @example
     * $handler->setRedirectRoute('error.page', ['type' => 'validation']);
     */
    public function setRedirectRoute(string $route, array $parameters = []): self
    {
        $this->redirectBehavior = function () use ($route, $parameters) {
            return route($route, $parameters);
        };
        return $this;
    }

    /**
     * Set the redirect behavior to go back to the previous page.
     *
     * @return self
     *
     * @example
     * $handler->setRedirectBack();
     */
    public function setRedirectBack(): self
    {
        $this->redirectBehavior = function () {
            return url()->previous();
        };
        return $this;
    }

    /**
     * Add query parameters to the redirect URL.
     *
     * @param array $params The query parameters to add.
     * @return self
     *
     * @example
     * $handler->withQueryParameters(['source' => 'validation_error']);
     */
    public function withQueryParameters(array $params): self
    {
        $this->queryParameters = $params;
        return $this;
    }

    /**
     * Add a fragment to the redirect URL.
     *
     * @param string|null $fragment The fragment to add.
     * @return self
     *
     * @example
     * $handler->withFragment('error-section');
     */
    public function withFragment(?string $fragment): self
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     * Set whether to flash input to the session.
     *
     * @param bool $flash Whether to flash input.
     * @return self
     *
     * @example
     * $handler->flashInput(false);
     */
    public function flashInput(bool $flash = true): self
    {
        $this->flashInput = $flash;
        return $this;
    }

    /**
     * Set a flash message for the session.
     *
     * @param string $message The message to flash.
     * @param string|null $key The key to use for the flashed message.
     * @return self
     *
     * @example
     * $handler->withFlashMessage('Validation failed. Please check your input.', 'warning');
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
     * Perform the validation.
     *
     * @throws ValidationException If validation fails.
     * @return void
     *
     * @example
     * try {
     *     $handler->validate();
     * } catch (ValidationException $e) {
     *     // Handle validation failure
     * }
     */
    public function validate(): void
    {
        $validator = validator($this->request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            $errors = $validator->errors();

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

            if ($this->flashInput) {
                $this->request->flash();
            }

            if ($this->flashMessage) {
                session()->flash($this->flashMessageKey, $this->flashMessage);
            }

            throw $exception;
        }
    }
}
