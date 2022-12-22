<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits\Eloquent;

use function Midnite81\Core\Functions\uuid;

trait HasUuid
{
    /**
     * Register the model events for generating the UUID.
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
     * Update all uuids
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
