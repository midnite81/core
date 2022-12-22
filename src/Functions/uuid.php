<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

/**
 * Generates as UUID 4 string
 *
 * @return string
 */
function uuid(): string
{
    return app('m81-uuid')->generate();
}
