<?php

declare(strict_types=1);

namespace Midnite81\Core\Functions;

/**
 * Generates as UUID 4 string
 *
 * Example Usage: \Midnite81\Core\Functions\uuid()
 * Example Return: 90517cea-8a9e-46c1-8c44-1a3c03611786
 *
 * @return string
 */
function uuid(): string
{
    return app('m81-uuid')->generate();
}
