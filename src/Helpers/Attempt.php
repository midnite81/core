<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Closure;
use Midnite81\Core\Entities\AttemptEntity;
use Throwable;

class Attempt
{
    public static function attempt(Closure $closure): AttemptEntity
    {
        $result = null;
        $throwable = null;

        try {
            $result = $closure();
        } catch (Throwable $e) {
            $throwable = $e;
        }

        return new AttemptEntity($result, $throwable);
    }
}
