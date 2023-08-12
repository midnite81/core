<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Eloquent;

use Illuminate\Support\Facades\DB;

trait IncrementableSortOrder
{
    /**
     * Update the sort order of records in the model's table.
     *
     * This method assigns incremented values to the sort order column based on
     * the current order of records. The increment value and the sort order (column and direction)
     * can be customized via the associated methods.
     *
     * It makes use of raw SQL to perform the update efficiently, leveraging
     * MySQL's user-defined variable for incrementing values.
     *
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateIncrementedSortOrder(): bool
    {
        DB::statement('SET @row_number := 0;');

        $query = sprintf(
            'UPDATE %s SET %s = (@row_number := @row_number + %s) ORDER BY %s %s;',
            $this->getTable(),
            $this->getSortOrderColumn(),
            $this->getIncrementSeparation(),
            $this->getSortOrderColumn(),
            $this->getSortOrderDirection()
        );

        return DB::statement($query);
    }

    /**
     * Get the increment separation.
     *
     * This method returns the value by which the row number should be incremented
     * when updating the sort order for the table.
     *
     * @return int Increment separation value.
     */
    protected function getIncrementSeparation(): int
    {
        return 10;
    }

    /**
     * Get the column used for sorting.
     *
     * This method returns the name of the column by which records should be
     * sorted when updating the sort order.
     *
     * @return string Name of the column for sorting.
     */
    protected function getSortOrderColumn(): string
    {
        return 'sort_order';
    }

    /**
     * Get the direction of sorting.
     *
     * This method returns the direction (ascending or descending) in which
     * records should be sorted when updating the sort order.
     *
     * @return string Sorting direction (e.g., 'asc' or 'desc').
     */
    protected function getSortOrderDirection(): string
    {
        return 'asc';
    }
}
