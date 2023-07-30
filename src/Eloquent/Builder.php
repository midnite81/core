<?php

declare(strict_types=1);

namespace Midnite81\Core\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Builder
{
    /**
     * Returns the SQL query with its bindings
     */
    public static function getQueries(EloquentBuilder|QueryBuilder $builder): string
    {
        $bindings = $builder->getBindings();
        $addSlashes = str_replace(['?', '%'], ["'?'", '%%'], $builder->toSql());

        $formattedBindings = array_map(static function ($binding) {
            // Check if the binding is numeric, if yes, return without single quotes
            return is_numeric($binding) ? (string)$binding : "'$binding'";
        }, $bindings);

        return vsprintf(str_replace("'?'", '%s', $addSlashes), $formattedBindings);
    }
}
