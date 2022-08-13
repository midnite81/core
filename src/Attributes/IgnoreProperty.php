<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IgnoreProperty
{
    public function __construct()
    {
    }
}
