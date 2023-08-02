<?php

declare(strict_types=1);

namespace Midnite81\Core\Exceptions\MagicMethods;

class PropertyRequiresCanSetViaMagicMethodAttributeException extends \Exception
{
    public function __construct(string $propertyName)
    {
        $message = "Property '{$propertyName}' requires the 'CanSetViaMagicMethod' attribute to be set using magic methods.";
        parent::__construct($message);
    }
}
