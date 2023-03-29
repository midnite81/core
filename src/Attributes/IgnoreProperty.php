<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * This attribute is used to define a property as ignored so it will not be outputted to arrays or json etc.
 *
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IgnoreProperty
{
    public function __construct()
    {
    }
}
