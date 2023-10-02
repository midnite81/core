<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions;

use Exception;

class MethodNotImplementedException extends Exception
{
    public static function forUnimplementedClassMethod(object $class, string $methodName): static
    {
        $message = 'Method %s has not been implemented on class %s';

        return new static(sprintf($message, $methodName, get_class($class)));
    }

    public static function forUnimplementedFunction(string $functionName): static
    {
        $message = 'Function %s has not been implemented';

        return new static(sprintf($message, $functionName));
    }
}
