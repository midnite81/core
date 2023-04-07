<?php

declare(strict_types=1);

namespace Midnite81\Core\Store\Actions;

use Illuminate\Database\Eloquent\Model;

abstract class BaseAction
{
    /**
     * The model which the action is based upon.
     * To be set at extended class level
     */
    protected Model $model;

    /**
     * Store data to the model
     */
    protected function internalStore(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * Update data to the passed model
     */
    protected function internalUpdate(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * Updates or creates a record
     */
    protected function internalUpdateOrCreate(array $attributes, array $data): Model
    {
        return $this->model->newQuery()->updateOrCreate($attributes, $data);
    }
}
