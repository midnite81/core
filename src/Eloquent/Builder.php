<?php

declare(strict_types=1);

namespace Midnite81\Core\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Builder
{
    /**
     * Returns the sql query with its bindings
     *
     * @param EloquentBuilder|QueryBuilder $builder
     * @return string
     */
    public static function getQueries(EloquentBuilder|QueryBuilder $builder): string
    {
        $addSlashes = str_replace(['?', '%'], ["'?'", '%%'], $builder->toSql());

        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}
