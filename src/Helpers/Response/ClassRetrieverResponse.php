<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers\Response;

use Midnite81\Core\Responses\BaseResponse;

class ClassRetrieverResponse extends BaseResponse
{
    /**
     * The fully qualified name of the class/interface/trait
     */
    public string $name;

    /**
     * The type of class
     * Example: class, interface, trait
     */
    public string $type;

    /**
     * The class that the class extends
     */
    public string $extends;

    /**
     * An array of the interfaces that the class implements
     */
    public array $implements;

    /**
     * An array of the traits that the class uses
     */
    public array $traits;

    /**
     * Whether the class is abstract
     */
    public bool $isAbstract;
}
