<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\General;

use Exception;

class ClassMustInheritFromException extends Exception
{
    /**
     * @param mixed $class
     * @param mixed $inheritFromClass
     */
    public function __construct(mixed $class, mixed $inheritFromClass)
    {
        $className = is_object($class) ? get_class($class) : $class;
        $extendClassName = is_object($inheritFromClass) ? get_class($inheritFromClass) : $inheritFromClass;

        $message = "{$class} must implement from {$inheritFromClass}";

        parent::__construct($message, 0, null);
    }
}
