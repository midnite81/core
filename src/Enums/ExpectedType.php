<?php

declare(strict_types=1);

namespace Midnite81\Core\Enums;

enum ExpectedType: string
{
    case Object = 'object';
    case Array = 'array';
    case String = 'string';
}
