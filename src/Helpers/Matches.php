<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Illuminate\Support\Collection;
use Midnite81\Core\Entities\Matches\MatchEntity;

class Matches
{
    public static function match(string $pattern, string $string): MatchEntity
    {
        $matched = (bool) preg_match($pattern, $string, $matches);

        return new MatchEntity($matched, new Collection($matches));
    }
}
