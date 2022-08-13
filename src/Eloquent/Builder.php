<?php

declare(strict_types=1);

namespace Midnite81\Core\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Builder
{
    public static function getQueries(EloquentBuilder $builder): string
    {
        $addSlashes = str_replace(['?', '%'], ["'?'", '%%'], $builder->toSql());

        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}
