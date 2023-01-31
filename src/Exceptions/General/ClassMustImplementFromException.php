<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\General;

use Exception;

class ClassMustImplementFromException extends Exception
{
    /**
     * @param mixed $class
     * @param mixed $extendClass
     */
    public function __construct(mixed $class, mixed $extendClass)
    {
        $className = is_object($class) ? get_class($class) : $class;
        $extendClassName = is_object($extendClass) ? get_class($extendClass) : $extendClass;

        $message = "{$class} must implement from {$extendClass}";

        parent::__construct($message, 0, null);
    }
}
