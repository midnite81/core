<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasSortOrder
 *
 * @method Builder sort()
 */
trait HasSortable
{
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy(
            $this->getSortOrderColumn(),
            $this->getSortOrderDirection()
        );
    }

    public function getSortOrderColumn(): string
    {
        return 'sort_order';
    }

    public function getSortOrderDirection(): string
    {
        return 'ASC';
    }
}
