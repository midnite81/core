<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Eloquent;

use function Midnite81\Core\Functions\uuid;

trait HasUuid
{
    /**
     * Boot the "HasUuid" trait for a model.
     *
     * This method is called automatically when the trait is being used by a model.
     * It registers a "creating" event that generates a UUID and assigns it to the specified column.
     */
    public static function bootHasUUID(): void
    {
        static::creating(function ($model) {
            $column = $model->getUuidColumn();
            $model->$column = uuid();
        });
    }

    /**
     * Get the column that contains the UUID.
     *
     * @return string
     */
    public function getUuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * Update all UUIDs for the model's records.
     *
     * This method retrieves all records from the model's table and updates the UUID column with a new UUID.
     * The `uuid()` function is used to generate a new UUID.
     * Note: This method might not be practical for large datasets as it updates each record one by one.
     */
    public function updateUuids(): void
    {
        $allRecords = $this->all();

        if ($allRecords) {
            foreach ($allRecords as $record) {
                $activeRecord = $this->find($record->id);
                $activeRecord->update([
                    $this->getUuidColumn() => uuid(),
                ]);
            }
        }
    }
}
