<?php

declare(strict_types=1);

namespace Midnite81\Core\Attributes;

use Attribute;

/**
 * This attribute requires class properties to be required
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class RequiredProperty
{
}
