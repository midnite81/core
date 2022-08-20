<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Illuminate\Support\Collection;
use Midnite81\Core\Entities\Matches\MatchEntity;

class Matches
{
    public static function match(
        string $pattern,
        string $string,
        bool $global = false,
        int $flags = 0,
        int $offset = 0
    ): MatchEntity {
        $matches = [];

        $function = $global ? 'preg_match_all' : 'preg_match';
        $matched = (bool) $function($pattern, $string, $matches, $flags, $offset);

        return new MatchEntity($matched, new Collection($matches));
    }
}
