<?php

declare(strict_types=1);

namespace Midnite81\Core\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as BuilderAlias;

class Builder
{
    public static function getQueries(EloquentBuilder|BuilderAlias $builder): string
    {
        $addSlashes = str_replace(['?', '%'], ["'?'", '%%'], $builder->toSql());

        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}
